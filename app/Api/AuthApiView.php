<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 04:08 PM
 */

namespace App\Api;

use App\Core\Config;
use App\Factories\ResponseFactory;
use App\Utils\SecurityUtils;
use DbModels\Entities\User;
use DbModels\Repositories\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthApiView
 * @package App\Api
 */
class AuthApiView
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

    public function __invoke(ServerRequestInterface $request) : ResponseInterface
    {
        $params = $request->getParsedBody();

        $username = $params["username"] ?? '';
        $pswd = $params["pswd"] ?? '';

        if (!$username || !$pswd) {
            $response = ResponseFactory::buildBasicBadJsonResponse();
            $response->getBody()->write(\json_encode(["msg" => "Error en autenticación"]));
            return $response;
        }

        /** @var UserRepository $repository */
        $repository = $this->em->getRepository(User::class);

        /** @var User $register */
        $register = $repository->findOneBy(['username' => $username]);

        if (!$register) {
            $response = ResponseFactory::buildBasicBadJsonResponse();
            $response->getBody()->write(\json_encode(["msg" => "Error en autenticación"]));
            return $response;
        }

        $seed = $this->config->get('APP_SECURITY_SEED', '');

        if (!SecurityUtils::verifySecurePaswFromHash($pswd, $seed, $register->getPswd())) {
            $response = ResponseFactory::buildBasicBadJsonResponse();
            $response->getBody()->write(\json_encode(["msg" => "Error en autenticación"]));
            return $response;
        }

        $secret = $this->config->get('APP_JWT_SECRET', '');
        $tokenData = [
            "iat" => \time(),
            "nbf" => \time(),
            "sub" => \uniqid(),
            'userId' => $register->getId(),
            'name' => $register->getName(),
        ];

        $token = SecurityUtils::encodeDataToJwt($secret, $tokenData);

        $data = [
            'msg' => 'Ok',
            'token' => $token,
            'userId' => $register->getId(),
        ];

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write(\json_encode($data));
        return $response;
    }
}