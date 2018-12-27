<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 04:37 PM
 */

namespace App\Api\InventoryEvidence;

use App\Core\Config;
use App\Data\Transformers\InventoryEvidenceEntityTransformer;
use App\Factories\ResponseFactory;
use DbModels\Entities\InventoryEvidence;
use DbModels\Repositories\InventoryEvidenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class InventoryEvidenceReadRegistersApiView
 * @package App\Api\InventoryEvidence
 */
class InventoryEvidenceReadRegistersApiView
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
        $authData = $request->getAttribute('authData');
        $userId = !$authData['userId'] ? null : (int)$authData['userId'];

        $queryParams = $request->getQueryParams();
        $include = $queryParams['include'] ?? false;

        /** @var InventoryEvidenceRepository $repo */
        $repo = $this->em->getRepository(InventoryEvidence::class);

        $registers = $repo->getValidRegistersFromUserId($userId);

        $manager = new Manager();
        if ($include) {
            $manager->parseIncludes($include);
        }
        $manager->setSerializer(new DataArraySerializer);
        $resource = new Collection($registers, new InventoryEvidenceEntityTransformer);
        $body = $manager->createData($resource);

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write($body->toJson());

        return $response;
    }
}