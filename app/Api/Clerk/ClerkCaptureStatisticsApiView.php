<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 4/01/19
 * Time: 11:48 AM
 */

namespace App\Api\Clerk;

use App\Core\Config;
use App\Factories\ResponseFactory;
use Doctrine\ORM\EntityManagerInterface;
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

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\file_get_contents(BASE_DIR . "/storage/dummy-clerk-capture-statistics.json"));

        return $response;
    }
}