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
use DbModels\Entities\InventoryEvidence;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetTotalInventoryFilterByDateApiView
{

    /** @var Config */
    protected $config;

    /** @var EntityManagerInterface */
    protected $em;

    public function setConfig(Config $config): void
    {
        $this -> config = $config;
    }

    public function setEm(EntityManagerInterface $em): void
    {
        $this -> em = $em;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $args
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $params = $request -> getQueryParams();

        $repo = $this -> em -> getRepository(InventoryEvidence::class);

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode(["count" => (int)$repo -> getTotalRegisters($params)]));

        return $response;
    }
}
