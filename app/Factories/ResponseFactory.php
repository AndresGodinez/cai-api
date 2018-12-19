<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 26/11/18
 * Time: 03:35 PM
 */

namespace App\Factories;

use App\Consts\Http;
use App\Utils\ResponseUtils;
use Zend\Diactoros\Response;

class ResponseFactory
{
    public static function buildBasicJsonResponse()
    {
        $response = new Response();

        ResponseUtils::addContentTypeJsonHeader($response);

        return $response;
    }

    public static function buildBasicBadJsonResponse()
    {
        $response = (new Response)->withStatus(Http::STATUS_CODE_HTTP_BAD_REQUEST);
        ResponseUtils::addContentTypeJsonHeader($response);

        return $response;
    }
}