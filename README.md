# CEI API

CEI API for EY's LOREAL project.
CEI understands for 'Captura de Evidencias de Inventarios'

## Installation

1.- Create database and user in your MySQL (MariaDB) instance.

```mariadb
drop database if exists `EYCei`;
drop database if exists `test_EYCei`;

create database `EYCei` character set utf8 collate utf8_general_ci;
create database `test_EYCei` character set utf8 collate utf8_general_ci;
create user `ey_cei_admin`@localhost identified by 'PSWD';

grant all privileges on `EYCei`.* to `sea_pt_admin`@localhost;
grant all privileges on `test_EYCei`.* to `sea_pt_admin`@localhost;
flush privileges;
```

2.- Create env file at project root directory. Can create one based on template file named .env.tpl on root directory.

```bash
cp .env.tpl .env
```

Configure the user and password (***from the previous step***) for the project's doctrine configuration, and take care of the next variables.

* Set the `DOCTRINE_ENTITIES_PATH` var to the absolute path for the **/db-models/Mappings** project directory.
* Set the `PDO_DRIVER` var as **`mysql`**.
* Set the `DOCTRINE_DRIVER` and `DOCTRINE_TEST_DRIVER` vars as **`pdo_mysql`**.
* Set the `APP_LOGS_BASE_DIR` var to an existent directory (like [root_dir]/storage/logs) with permissions (preferably 0755). 

3.-  Install the composer dependencies.

```bash
composer install
``` 

4.- Execute the next command to init some project-related stuff (files, directories, etc).

```bash
composer init-project
```

5.- Run the tests with the phpunit, from the root directory.

```bash
./vendor/bin/phpunit tests/
```

If all the test passed, the configuration is OK.

## DB migrations

The application uses the [Doctrine Migration library (v1.*)](https://www.doctrine-project.org/projects/doctrine-migrations/en/latest/reference/introduction.html#introduction).

To initialize the database (run the migrations), execute the next command from the root directory:

```bash
composer m:migrate
```

To initialize the tests DB, you must change the next line at the cli-config.php file.

```php
// production entity manager (comment or remove this line)
$entityManager = $container->get('entity-manager');

// tests entity manager (set this line)
$entityManager = $container->get('test-entity-manager');
```

After change the file, just executes the `composer m:migrate` script.

***Don't forget to return the cli-config.php file to it's original content (with `entity-manager` instead of `test-entity-manager`).

## Directory structure

### /app

> The core app directory. You can declare your stuff here.

### /app/Core
> Here lies the Container and Router interfaces. The Config class app is here too.

> You can add new routes at the AppRouter class. (Library doc: [Route v4 | The PHP League](http://route.thephpleague.com/4.x/))

> To add new services (like controllers and other DI stuff), you can create the files at the ContainerProviders directory. (Library doc: [Container v3 | The PHP League](http://container.thephpleague.com/3.x/))

> Here lies the Middleware directory, where you can create your custom Route middleware.

### /app/Exceptions

> You can create custom exceptions in this directory. (preferably extended from base `\Exception` class or from `App\Exceptions\InternalException` class)

### /app/Api

> You can create the Route callables at this directory. Please, use a prefix for the files created at this directory, like **Controller** or **ApiView**.

> Use the next snippet to create your callables.

```php
<?php

namespace App\Api;

use App\Factories\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestView
{
    /**
     * TestView constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request) : ResponseInterface
    {
        $response = ResponseFactory::buildBasicJsonResponse();

        $response->getBody()->write("{test: 1}");

        return $response;
    }
}
```

> Then, add the view to the ApiProvider class (or your own provider) at */app/Core/ContainerProviers* directory.

```
    use App\Api\TestView;
    ...
    protected $provides = [
        TestView::class,
    ];
    ...
    public function register()
    {
        $this->container->add(TestView::class);
    }
```
### /db-models (DbModels namespace)

> Data Layer package (module). Here lies the classes related to the data-layer of the application.

### /db-moodels/Consts

> The entities consts directory. To implement human-readable versions of the constants (values) used in the tables (DB).

### /db-models/Entities

> Entities (models) directory.

### /db-models/Mappings

> DB <-> App (ORM) mappings directory. Every Entity must have its own Mapping class. To set a mapping class to the entity, see the method `loadMetadata` at the desired Entity class.

```php
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new TestMapping;
        $builder($metadata);
    }
```

### /db-models/Repositories

> Entities repositories directory, to implement custom queries or procedures that involve the DBAL.


## Logging

The project uses the [Monolog](https://github.com/Seldaek/monolog) library (v1.24).

To instance the monolog logger, from every where in the code, just run the following code:
```php
// with a valid config instance (injected or instanced in the way)
// $config = $container->get('model-config');

$logger = LoggerFactory::buildDebugLoggerFromConfig($config);
```

To write content to the log, use the next code:
```php
$logger->debug('test message');
```

If you want to write an object, print it with the \print_r command, like the follows:
```php
$obj = new stdClass;
$logger->debug(\print_r($obj, true));
```

## Composer special scripts

### Lint

You can run lint over your source files with the next command. It is used to validate the sintax of your code.

```bash
composer lint
```

### Code Style

The project follows the recommendations [PSR-1](https://www.php-fig.org/psr/psr-1/) and [PSR-2](https://www.php-fig.org/psr/psr-2/). Run the next command to validate your code style, and fix your issues if some appear.

```bash
composer cs-check
```


## License
[CC BY-ND 4.0](https://creativecommons.org/licenses/by-nd/4.0/)