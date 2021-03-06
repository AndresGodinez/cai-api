<?php
/**
 * Created by PhpStorm.
 * User: aGodinez
 * Date: 2019-01-03
 * Time: 10:19
 */

namespace App\Api\InventoryEvidence;

use App\Core\Config;
use App\Factories\ResponseFactory;
use const BASE_DIR;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetInventoryEvidenceApiView
{
    protected $config;

    protected $em;

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function setEm(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    public function __invoke(ServerRequestInterface $request, array $args) : ResponseInterface
    {
        $data = \file_get_contents(BASE_DIR. '/storage/jsonapp.json');
        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write($data);

        return $response;
    }
}
