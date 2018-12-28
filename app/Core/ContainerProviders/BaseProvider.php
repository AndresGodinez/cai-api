<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 04:35 PM
 */

namespace App\Core\ContainerProviders;

use App\Core\AppRouter;
use App\Core\Config;
use App\Exceptions\InternalException;
use App\Factories\ConfigFactory;
use App\Utils\RequestUtils;
use Doctrine\Common\Persistence\Mapping\Driver\StaticPHPDriver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Dotenv\Dotenv;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class BaseProvider
 * @package App\Core\ContainerProviders
 */
class BaseProvider extends AbstractServiceProvider
{
    /** @var string Base directory for the application (normally defined on bootstrap script) */
    protected $baseDir = '';

    /**
     * @var array
     */
    protected $provides = [
        'request',
        'router',
        'array-config',
        'model-config',
        'entity-manager',
        'test-entity-manager',
        'emitter',
        'local-filesystem',
        'inventory-evidence-photos-filesystem',
        'test-inventory-evidence-photos-filesystem',
    ];

    /**
     * BaseProvider constructor.
     * @param string $baseDir
     */
    public function __construct(string $baseDir)
    {
        $this->baseDir = $baseDir;
    }


    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $baseDir = $this->baseDir;

        $container->share('request', function () {
            $parsedBody = RequestUtils::getParsedBodyFromServer($_SERVER, $_POST);
            return ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $parsedBody,
                $_COOKIE,
                $_FILES
            );
        });

        $container->add('router', function () use ($container) {
            $invokable = new AppRouter;

            if (!($container instanceof Container)) {
                throw new \Exception("Invalid container interface");
            }

            return $invokable($container);
        });

        $container->share('array-config', function () use ($baseDir) {
            $dotenv = new Dotenv($baseDir);
            $dotenv->load();
            $config = $_ENV;

            return $config;
        });

        $container->add('model-config', function () use ($baseDir) {
            return ConfigFactory::buildFromPath($baseDir);
        });

        $container->share('local-filesystem', function () use ($baseDir) {
            $sharedDir = $baseDir . '/storage/local' ?? '';

            $adapter = new Local($sharedDir);
            $filesystem = new Filesystem(
                $adapter,
                new \League\Flysystem\Config([
                    'disable_asserts' => true,
                ])
            );

            return $filesystem;
        });

        $container->share('inventory-evidence-photos-filesystem', function () use ($baseDir, $container) {
            if (\defined('TESTING') && !!TESTING) {
                return $container->get('test-inventory-evidence-photos-filesystem');
            }

            $sharedDir = $baseDir . '/storage/inventory-evidence-photos' ?? '';

            $adapter = new Local($sharedDir);
            $filesystem = new Filesystem(
                $adapter,
                new \League\Flysystem\Config([
                    'disable_asserts' => true,
                ])
            );

            return $filesystem;
        });

        $container->share('test-inventory-evidence-photos-filesystem', function () use ($baseDir) {
            $sharedDir = $baseDir . '/tests/test-storage/inventory-evidence-photos' ?? '';

            $adapter = new Local($sharedDir);
            $filesystem = new Filesystem(
                $adapter,
                new \League\Flysystem\Config([
                    'disable_asserts' => true,
                ])
            );

            return $filesystem;
        });

        $container->add('entity-manager', function (Config $config) use ($container) {
            if (\defined('TESTING') && !!TESTING) {
                return $container->get('test-entity-manager');
            }

            $dbEntitiesPath = $config->get('DOCTRINE_ENTITIES_PATH', false);
            $host = $config->get('DOCTRINE_HOST', '');
            $driver = $config->get('DOCTRINE_DRIVER', 'pdo_mysql');
            $user = $config->get('DOCTRINE_USERNAME', false);
            $password = $config->get('DOCTRINE_PSWD', false);
            $charset = $config->get('DOCTRINE_CHARSET', 'utf8');
            $dbname = $config->get('DOCTRINE_DB', false);

            if (!$dbEntitiesPath || !$driver || !$host || !$user || !$password || !$dbname) {
                throw new InternalException("Invalid configuration");
            }

            $paths = [$dbEntitiesPath];
            $isDevMode = true;

            // the connection configuration
            $dbParams = [
                'host' => $host,
                'driver' => $driver,
                'user' => $user,
                'password' => $password,
                'dbname' => $dbname,
                'charset' => $charset,
            ];

            $driver = new StaticPHPDriver($paths);

            $config = Setup::createConfiguration($isDevMode);
            $config->setMetadataDriverImpl($driver);
            $em = EntityManager::create($dbParams, $config);

            return $em;
        })
            ->addArgument('model-config');

        $container->add('test-entity-manager', function (Config $config) {
            $dbEntitiesPath = $config->get('DOCTRINE_ENTITIES_PATH', false);
            $host = $config->get('DOCTRINE_TEST_HOST', '');
            $driver = $config->get('DOCTRINE_TEST_DRIVER', 'pdo_mysql');
            $user = $config->get('DOCTRINE_TEST_USERNAME', false);
            $password = $config->get('DOCTRINE_TEST_PSWD', false);
            $charset = $config->get('DOCTRINE_TEST_CHARSET', 'utf8');
            $dbname = $config->get('DOCTRINE_TEST_DB', false);

            if (!$dbEntitiesPath || !$driver || !$host || !$user || !$password || !$dbname) {
                throw new InternalException("Invalid configuration");
            }

            $paths = [$dbEntitiesPath];
            $isDevMode = true;

            // the connection configuration
            $dbParams = [
                'host' => $host,
                'driver' => $driver,
                'user' => $user,
                'password' => $password,
                'dbname' => $dbname,
                'charset' => $charset,
            ];

            $driver = new StaticPHPDriver($paths);

            $config = Setup::createConfiguration($isDevMode);
            $config->setMetadataDriverImpl($driver);
            $em = EntityManager::create($dbParams, $config);

            return $em;
        })
            ->addArgument('model-config');

        $container->share('emitter', SapiEmitter::class);
    }
}
