<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 10:15 AM
 */

namespace App\Api\Indicator;

use App\Core\Config;
use App\Data\Transformers\ProgressPercByClerkDataTransformer;
use App\Factories\ResponseFactory;
use DbModels\Entities\StoreClerk;
use DbModels\Repositories\StoreClerkRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ProgressPercByClerkApiView
 * @package App\Api\Indicator
 */
class ProgressPercByClerkApiView
{
    /** @var Config */
    protected $config;

    /** @var EntityManagerInterface */
    protected $em;

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function setEm(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, array $args) : ResponseInterface
    {
        /** @var StoreClerkRepository $repo */
        $repo = $this->em->getRepository(StoreClerk::class);

        $data = $repo->getProgressPercByClerkData();

        $manager = new Manager();
        $resource = new Collection($data, new ProgressPercByClerkDataTransformer);
        $body = $manager->createData($resource);
        $bodyArr = $body->toArray();

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode($bodyArr['data']));

        return $response;
    }
}