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
use function array_push;
use function array_unique;
use function array_values;
use DbModels\Entities\InventoryEvidence;
use DbModels\Entities\StoreClerk;
use DbModels\Repositories\StoreClerkRepository;
use Doctrine\ORM\EntityManagerInterface;
use function in_array;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ProgressPercByStateApiView
 * @package App\Api\Indicator
 */
class ProgressByBrandApiView
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
        $repo = $this->em->getRepository(InventoryEvidence::class);

        $registers = $repo->getProgressByBrand();

        $uniqueBrandsIds = [];

        foreach ($registers as $register) {
            array_push($uniqueBrandsIds, $register['brandId']);
        }
        $uniqueBrandsIds = array_values(array_unique($uniqueBrandsIds));

        $groupByBrand = [];

        foreach ($uniqueBrandsIds as $brandId) {
            $group = \array_filter($registers, function ($item) use ($brandId) {
                return $item['brandId'] === $brandId;
            });
            array_push($groupByBrand, $group);
        }

        $groupResponse = [];

        for ($i = 0; $i< count($groupByBrand); $i++){
            $groupByBrand[$i] = array_values($groupByBrand[$i]);
            $item = $groupByBrand[$i];
            $quantity = count($item);

            array_push($groupResponse, [
                'brandName' => $groupByBrand[$i][0]['brandName'],
                'brandId'=>  $groupByBrand[$i][0]['brandId'],
                'quantity' => $quantity
            ]);
        }

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode($groupResponse));

        return $response;
    }
}