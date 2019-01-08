<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 04:37 PM
 */

namespace App\Api\InventoryEvidence;

use App\Core\Config;
use App\Factories\ResponseFactory;
use DbModels\Entities\InventoryEvidence;
use DbModels\Repositories\InventoryEvidenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class InventoryEvidenceReadRegistersCountApiView
 * @package App\Api\InventoryEvidence
 */
class InventoryEvidenceReadRegistersCountApiView
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
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(ServerRequestInterface $request, array $args) : ResponseInterface
    {
        $authData = $request->getAttribute('authData');
        $userId = !$authData['userId'] ? null : (int)$authData['userId'];

        /** @var InventoryEvidenceRepository $repo */
        $repo = $this->em->getRepository(InventoryEvidence::class);

        $total = $repo->getValidRegistersCountFromUserId($userId);

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode(["total" => (int)$total]));

        return $response;
    }
}