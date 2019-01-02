<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 2/01/19
 * Time: 01:56 PM
 */

namespace App\Core\Middlewares;

use App\Factories\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ValidatePhotoUploadSizesApiMiddleware
 * @package App\Core\Middlewares
 */
class ValidatePhotoUploadSizesApiMiddleware implements MiddlewareInterface
{
    /** @var array $config */
    protected $config = null;

    /**
     * SecureApiQueryParamMiddleware constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uploadedFiles = $request->getUploadedFiles();

        if (!$uploadedFiles || \count($uploadedFiles) === 0) {
            $response = ResponseFactory::buildBasicBadJsonResponse();
            $response->getBody()->write(\json_encode(['msg' => 'No se recibieron fotos para procesar.']));
            return $response;
        }

        $validMimeTypesRegex = '/^image\/(?:png|jpe?g)$/i';
        $limitPhotoSize = $this->config['APP_LIMIT_SIZE_PHOTO'] ?? 0;
        $limitPhotosRequestSize = $this->config['APP_LIMIT_SIZE_PHOTOS_REQUEST'] ?? 0;

        $uploadedPhotosFilesSize = 0;

        $err = '';
        /** @var UploadedFileInterface $uploadedFile */
        foreach ($uploadedFiles as $uploadedFile) {
            // validate mime-type
            if (!preg_match($validMimeTypesRegex, $uploadedFile->getClientMediaType())) {
                $err = 'Uno de los archivos no es del formato esperado (JPEG, PNG).';
                break;
            }

            $uploadedFileMbSize = \round($uploadedFile->getSize() / 1048576, 2);
            if ($uploadedFileMbSize > $limitPhotoSize) {
                $err = 'Una de las fotos es demasiado grande para procesarse. Por favor, suba imágenes que no sobrepasen los ' . $limitPhotoSize . ' MB.';
                break;
            }

            $uploadedPhotosFilesSize += $uploadedFile->getSize();
        }

        $uploadedPhotosFilesSizeMb = \round($uploadedPhotosFilesSize / 1048576, 2);

        if (!$err && ($uploadedPhotosFilesSizeMb > $limitPhotosRequestSize)) {
            $err = 'Las fotos exceden el tamaño máximo de peso que se puede procesar (' . $limitPhotosRequestSize . ' MB)';
        }

        if (!!$err) {
            $response = ResponseFactory::buildBasicBadJsonResponse();
            $response->getBody()->write(\json_encode(['msg' => $err]));
            return $response;
        }

        return $handler->handle($request);
    }
}