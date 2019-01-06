<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 11:48 AM
 */

namespace App\Api\Clerk;

use App\Core\Config;
use App\Data\Models\ClerkCaptureStatisticData;
use App\Data\Transformers\ClerkCaptureStatisticDataTransformer;
use App\Factories\ResponseFactory;
use DbModels\Entities\Clerk;
use DbModels\Repositories\ClerkRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ClerkCaptureStatisticsApiView
 * @package App\Api\Clerk
 */
class ClerkCaptureStatisticsApiView
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
        $regId = $args['regId'] ?? null;
        $regId = !$regId ? $regId : (int)$regId;

        /** @var ClerkRepository $repo */
        $repo = $this->em->getRepository(Clerk::class);

        /** @var ClerkCaptureStatisticData $data */
        $data = $repo->getCaptureStatisticsData($regId);

        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer);
        $resource = new Item($data, new ClerkCaptureStatisticDataTransformer);
        $body = $manager->createData($resource);

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write($body->toJson());

        return $response;
    }
}