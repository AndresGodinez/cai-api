<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 11:11 AM
 */

namespace App\Api\InventoryEvidence;

use App\Core\Config;
use App\Exceptions\ValidationException;
use App\Factories\LoggerFactory;
use App\Factories\Requests\InventoryEvidenceRequestDataFactory;
use App\Factories\ResponseFactory;
use DbModels\Consts\InventoryEvidencePhotoType;
use DbModels\Entities\InventoryEvidence;
use DbModels\Entities\InventoryEvidencePhoto;
use DbModels\Entities\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class InventoryEvidenceCreateApiView
 * @package App\Api\InventoryEvidence
 */
class InventoryEvidenceCreateApiView
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
     */
    public function __invoke(ServerRequestInterface $request, array $args) : ResponseInterface
    {
        $authData = $request->getAttribute('authData');
        $userId = !$authData['userId'] ? null : (int)$authData['userId'];

        $params = $request->getParsedBody();
        $requestData = InventoryEvidenceRequestDataFactory::buildInventoryEvidenceCreateRegisterRequestData($this->em, $params);

        $logger = LoggerFactory::buildErrorLoggerFromConfig($this->config);

        $uploadedFiles = $request->getUploadedFiles();

        $now = new \DateTime();

        try {
            $requestData->validate();

            /** @var User $user */
            $user = $this->em->find(User::class, $userId);

            if (!$user) {
                throw new ValidationException("El usuario es inv??lido");
            }

            if (!$uploadedFiles) {
                throw new ValidationException("Las fotos/im??genes del inventario son inv??lidas");
            }

            if (!\array_key_exists('photo-furniture', $uploadedFiles)) {
                throw new ValidationException("La foto/imagen del mueble es inv??lida");
            }

            if (!\array_key_exists('photo-qrcode', $uploadedFiles)) {
                throw new ValidationException("La foto/imagen del c??digo QR es inv??lida");
            }
        } catch (ValidationException $ve) {
            $logger->error($ve->getMessage());

            $response = ResponseFactory::buildBasicBadJsonResponse();
            $bodyArr = ["msg" => "Error al validar los datos", "detail" => $ve->getMessage()];
            $response->getBody()->write(\json_encode($bodyArr));

            return $response;
        }

        // create photos registers
        $dirName = '/' . \uniqid();
        $nowStr = $now->format('Ymd-His');

        /** @var UploadedFileInterface $furnitureFile */
        $furnitureFile = $uploadedFiles['photo-furniture'];
        $furnitureFileExt = \pathinfo($furnitureFile->getClientFilename(), PATHINFO_EXTENSION);
        $furnitureFileNewFile = $dirName . '/furniture-photo-' . $nowStr . '.' . $furnitureFileExt;
        
        /** @var UploadedFileInterface $qrcodeFile */
        $qrcodeFile = $uploadedFiles['photo-qrcode'];
        $qrcodeFileExt = \pathinfo($qrcodeFile->getClientFilename(), PATHINFO_EXTENSION);
        $qrcodeFileNewFile = $dirName . '/qrcode-photo-' . $nowStr . '.' . $qrcodeFileExt;

        $photo1 = new InventoryEvidencePhoto();
        $photo1->setFilePath($furnitureFileNewFile);
        $photo1->setType(InventoryEvidencePhotoType::FURNITURE);

        $photo2 = new InventoryEvidencePhoto();
        $photo2->setFilePath($qrcodeFileNewFile);
        $photo2->setType(InventoryEvidencePhotoType::QR);

        // copy photos to directory
        $this->photosStorage->put($furnitureFileNewFile, $furnitureFile->getStream());
        $this->photosStorage->put($qrcodeFileNewFile, $qrcodeFile->getStream());

        /** @var InventoryEvidence $register */
        $register = $requestData->exportEntity();
        $register->setUser($user);
        $register->setRegCreatedDt($now);

        $register->addPhoto($photo1);
        $register->addPhoto($photo2);

        $this->em->persist($register);
        try {
            $this->em->flush();
        } catch (UniqueConstraintViolationException $ex) {
            $logger->error($ex->getMessage());
            $response = ResponseFactory::buildBasicBadJsonResponse();
            $response->getBody()->write(\json_encode(['msg' => 'El c??digo dado ya fue registrado con anterioridad.']));
            return $response;
        }

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode([
            'id' => $register->getId(),
            'msg' => 'Registro guardado con exito',
        ]));
        return $response;
    }
}