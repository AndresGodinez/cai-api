<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 28/11/18
 * Time: 02:27 PM
 */

namespace App\Utils;

use App\Consts\Http;
use App\Exceptions\ApiSecurityException;
use Psr\Http\Message\ServerRequestInterface;

class RequestUtils
{
    /**
     * @param ServerRequestInterface $request
     * @return mixed
     * @throws ApiSecurityException
     */
    public static function getJwtTokenFromAuthorizationHeader(ServerRequestInterface $request)
    {
        if (!$request->hasHeader(Http::HEADER_AUTHORIZATION)) {
            throw new ApiSecurityException('Unauthorized request');
        }

        $authorizationHeader = $request->getHeaderLine(Http::HEADER_AUTHORIZATION);

        if (!$authorizationHeader) {
            throw new ApiSecurityException('Unauthorized request');
        }

        list($jwt) = \sscanf($authorizationHeader, 'Bearer %s');

        return \base64_decode($jwt);
    }

    /**
     * @param array $server
     * @param array $defBody
     * @return array
     */
    public static function getParsedBodyFromServer(array $server, array $defBody)
    {
        // init default parsed body array
        $parsedBody = $defBody ?? [];
        // get request method
        $requestMethod = \strtolower($server['REQUEST_METHOD'] ?? '');
        // get content-type header
        $contentType = \strtolower($server['CONTENT_TYPE'] ?? '');
        // get requestBody string from input stream
        $requestBodyStr = \file_get_contents('php://input');
        $requestBody = [];
        // parse post json input or put input
        if (!!$requestBodyStr && \strpos($contentType, 'application/json') !== false) {
            // json content type
            $requestBody = \json_decode($requestBodyStr);
        } elseif (!!$requestBodyStr && ($requestMethod === 'put' || $requestMethod === 'delete')) {
            // parse put input
            \parse_str($requestBodyStr, $requestBody);
        }
        if (!empty($requestBody)) {
            $parsedBody = \array_merge($parsedBody, $requestBody);
        }
        return $parsedBody;
    }
}