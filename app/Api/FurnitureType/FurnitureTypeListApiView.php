<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 22/12/18
 * Time: 11:30 AM
 */

namespace App\Api\FurnitureType;

use App\Core\Config;
use App\Data\Transformers\FurnitureTypeListTransformer;
use App\Factories\ResponseFactory;
use DbModels\Entities\FurnitureType;
use DbModels\Repositories\FurnitureTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class FurnitureTypeListApiView
 * @package App\Api\FurnitureType
 */
class FurnitureTypeListApiView
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
     * @throws \App\Exceptions\InternalException
     */
    public function __invoke(ServerRequestInterface $request, array $args) : ResponseInterface
    {
        /** @var FurnitureTypeRepository $repo */
        $repo = $this->em->getRepository(FurnitureType::class);

        $registers = $repo->getValidRegisters();

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer);
        $resource = new Collection($registers, new FurnitureTypeListTransformer);
        $body = $manager->createData($resource);

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write($body->toJson());

        return $response;
    }
}