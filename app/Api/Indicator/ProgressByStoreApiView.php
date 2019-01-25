<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 10:15 AM
 */

namespace App\Api\Indicator;

use App\Core\Config;
use App\Factories\ResponseFactory;
use DbModels\Entities\Store;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ProgressByStoreApiView
 * @package App\Api\Indicator
 */
class ProgressByStoreApiView
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
        $storeRepo = $this->em->getRepository(Store::class);
        $quantityStores = $storeRepo->getQuantityStores();
        $quantityStores = $quantityStores[0]['quantity'];

        $storesWithAtLeastOneRecord = $storeRepo->storesWithAtLeastOneRecord();

        $storesWithout = $storeRepo->storesWithoutRegister();

        $arrayToResponse = [];

        $orderData = [
            'TotalStores' => $quantityStores,
            'storesWithAtLeastOneRecord' => $storesWithAtLeastOneRecord,
            'storesWithout' => $storesWithout
        ];

        \array_push($arrayToResponse, $orderData);

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode($arrayToResponse));

        return $response;
    }
}