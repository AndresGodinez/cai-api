<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 5/09/18
 * Time: 03:47 PM
 */

namespace App\Core\Middlewares;

use App\Exceptions\ViewInvalidSessionException;
use App\Traits\ConfigurableViewTrait;
use App\Utils\SessionUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ValidateSessionViewMiddleware
 * @package App\Core\Middlewares
 */
class ValidateSessionViewMiddleware
{
    /** @var array */
    private $config = [];

    /**
     * ValidateSessionViewMiddleware constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return mixed
     * @throws ViewInvalidSessionException
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        SessionUtils::initSessionFromConfig($this->config);

        $sessionName = $_SESSION['name'] ?? null;
        if (!$sessionName) {
            throw new ViewInvalidSessionException('Invalid session', 400);
        }

        return $handler->handle($request);
    }
}