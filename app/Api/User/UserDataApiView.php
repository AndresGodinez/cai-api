<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 21/12/18
 * Time: 03:47 PM
 */

namespace App\Api\User;

use App\Core\Config;
use App\Data\Models\UserData;
use App\Data\Transformers\UserDataTransformer;
use App\Factories\ResponseFactory;
use DbModels\Entities\User;
use DbModels\Repositories\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class UserDataApiView
 * @package App\Api\User
 */
class UserDataApiView
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

        $authData = $request->getAttribute('authData');
        $userId = !$authData['userId'] ? null : (int)$authData['userId'];
        if ($userId !== $regId) {
            $response = \App\Factories\ResponseFactory::buildUnauthorizedJsonResponse();
            $response->getBody()->write(\json_encode(['msg' => 'Invalid user request']));
            return $response;
        }

        /** @var UserRepository $userRepo */
        $userRepo = $this->em->getRepository(User::class);

        /** @var User $user */
        $user = $userRepo->find($regId);

        /** @var array $userData */
        $userData = $userRepo->getStatesDataFromUser($user);

        $register = new UserData();
        $register->setUser($user);
        $register->setUserData($userData);

        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer);
        $resource = new Item($register, new UserDataTransformer);
        $body = $manager->createData($resource);

        $response = ResponseFactory::buildBasicJsonResponse();
        $response->getBody()->write($body->toJson());

        return $response;
    }
}