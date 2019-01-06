<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 6/01/19
 * Time: 01:28 PM
 */

namespace App\Api\Brand;

use App\Core\Config;
use App\Data\Transformers\FurnitureTypeListTransformer;
use App\Factories\ResponseFactory;
use DbModels\Entities\Brand;
use DbModels\Repositories\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BrandFurnitureTypeListApiView
 * @package App\Api\Brand
 */
class BrandFurnitureTypeListApiView
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
        $regId = (int)$args['regId'];

        /** @var BrandRepository $repo */
        $repo = $this->em->getRepository(Brand::class);

        $registers = $repo->getFurnitureTypesFromBrand($regId);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer);
        $resource = new Collection($registers, new FurnitureTypeListTransformer);
        $body = $manager->createData($resource);

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write($body->toJson());

        return $response;
    }
}