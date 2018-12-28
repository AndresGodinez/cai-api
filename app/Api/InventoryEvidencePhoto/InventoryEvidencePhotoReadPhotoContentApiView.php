<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 06:49 PM
 */

namespace App\Api\InventoryEvidencePhoto;

use App\Consts\Http;
use App\Core\Config;
use DbModels\Entities\InventoryEvidencePhoto;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

/**
 * Class InventoryEvidencePhotoReadPhotoContentApiView
 * @package App\Api\InventoryEvidencePhoto
 */
class InventoryEvidencePhotoReadPhotoContentApiView
{
    /** @var Config */
    protected $config;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FilesystemInterface */
    protected $photosStorage;

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function setEm(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    /**
     * @param FilesystemInterface $photosStorage
     */
    public function setPhotosStorage(FilesystemInterface $photosStorage): void
    {
        $this->photosStorage = $photosStorage;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface
     * @throws \App\Exceptions\InternalException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function __invoke(ServerRequestInterface $request, array $args) : ResponseInterface
    {
        $regId = $args['regId'] ?? 0;

        /** @var InventoryEvidencePhoto $photo */
        $photo = $this->em->find(InventoryEvidencePhoto::class, $regId);

        $response = new Response;
        $response = $response->withHeader(Http::HEADER_CONTENT_TYPE, Http::CONTENT_TYPE_IMAGE_JPEG);
        $response->getBody()->write($this->photosStorage->read($photo->getFilePath()));

        return $response;
    }
}