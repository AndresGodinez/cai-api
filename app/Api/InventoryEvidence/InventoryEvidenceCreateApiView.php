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
use DbModels\Entities\InventoryEvidence;
use DbModels\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

        $params = $request->getParsedBody();
        $requestData = InventoryEvidenceRequestDataFactory::buildInventoryEvidenceCreateRegisterRequestData($this->em, $params);

        $logger = LoggerFactory::buildErrorLoggerFromConfig($this->config);

        try {
            $requestData->validate();

            /** @var User $user */
            $user = $this->em->find(User::class, $userId);

            if (!$user) {
                throw new ValidationException("El usuario es inválido");
            }
        } catch (ValidationException $ve) {
            $logger->error($ve->getMessage());

            $response = ResponseFactory::buildBasicBadJsonResponse();
            $bodyArr = ["msg" => "Fallo al validar los datos"];
            $response->getBody()->write(\json_encode($bodyArr));

            return $response;
        }

        /** @var InventoryEvidence $register */
        $register = $requestData->exportEntity();
        $register->setUser($user);
        $register->setRegCreatedDt(new \DateTime());

        $this->em->persist($register);
        $this->em->flush();

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode([
            'id' => 1,
            'msg' => 'Registro guardado con exito',
        ]));
        return $response;
    }
}