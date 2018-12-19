<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 26/11/18
 * Time: 03:34 PM
 */

namespace App\Utils;

use App\Consts\Http;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

/**
 * Class ResponseUtils
 * @package App\Utils
 */
class ResponseUtils
{
    /**
     * @param ResponseInterface $response
     */
    public static function addCorsHeader(ResponseInterface &$response)
    {
        $response = $response->withHeader(Http::HEADER_CORS, '*');
    }

    /**
     * @param ResponseInterface $response
     */
    public static function addContentTypeJsonHeader(ResponseInterface &$response)
    {
        $response = $response->withHeader(Http::HEADER_CONTENT_TYPE, Http::CONTENT_TYPE_APPLICATION_JSON_UTF8);
    }

    /**
     * @param ResponseInterface $response
     */
    public static function addContentTypeHtmlHeader(ResponseInterface &$response)
    {
        $response = $response->withHeader(Http::HEADER_CONTENT_TYPE, Http::CONTENT_TYPE_TEXT_HTML_UTF8);
    }

    /**
     * @param ResponseInterface $response
     */
    public static function addContentTypeSvgXmlHeader(ResponseInterface &$response)
    {
        $response = $response->withHeader(Http::HEADER_CONTENT_TYPE, Http::CONTENT_TYPE_IMAGE_SVG_XML);
    }

    /**
     * @param ResponseInterface $response
     * @param string $msg
     */
    public static function setBadRequestJsonResponse(ResponseInterface &$response, string $msg)
    {
        $response = $response->withStatus(Http::STATUS_CODE_HTTP_BAD_REQUEST);
        self::setMessageJsonResponse($response, $msg);
    }

    /**
     * @param ResponseInterface $response
     * @param string $msg
     */
    public static function setForbiddenJsonResponse(ResponseInterface &$response, string $msg)
    {
        $response = $response->withStatus(Http::STATUS_CODE_HTTP_FORBIDDEN);
        self::setMessageJsonResponse($response, $msg);
    }

    /**
     * @param ResponseInterface $response
     * @param string $msg
     */
    public static function setMessageJsonResponse(ResponseInterface &$response, string $msg)
    {
        self::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(["msg" => $msg], JSON_UNESCAPED_UNICODE));
    }

    /**
     * @param string $pdfFile
     * @param string $filename
     * @return Response
     */
    public static function setPdfFileResponse(string $pdfFile, string $filename)
    {
        $stream = new Stream($pdfFile, 'r');
        $fileSize = $stream->getSize();

        $response = new Response($stream, Http::STATUS_CODE_HTTP_OK, [
            Http::HEADER_CONTENT_TYPE => Http::CONTENT_TYPE_APPLICATION_PDF,

            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Content-Length' => $fileSize,
            'Content-Transfer-Encoding' => 'binary',
            'Pragma' => 'public',
        ]);

        return $response;
    }

    /**
     * @param string $file
     * @param string $filename
     * @return Response
     */
    public static function setXmlFileResponse(string $file, string $filename)
    {
        $stream = new Stream($file, 'r');
        $fileSize = $stream->getSize();

        $response = new Response($stream, Http::STATUS_CODE_HTTP_OK, [
            Http::HEADER_CONTENT_TYPE => Http::CONTENT_TYPE_APPLICATION_XML,

            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => $fileSize,
            'Content-Transfer-Encoding' => 'binary',
            'Pragma' => 'public',
        ]);

        return $response;
    }

    /**
     * @param string $filePath
     * @param string $filename
     * @return Response
     */
    public static function setXlsxFileResponse(string $filePath, string $filename)
    {
        $stream = new Stream($filePath, 'r');
        $fileSize = $stream->getSize();

        $response = new Response($stream, Http::STATUS_CODE_HTTP_OK, [
            Http::HEADER_CONTENT_TYPE => Http::CONTENT_TYPE_APPLICATION_SPREADSHEET,

            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => $fileSize,
            'Content-Transfer-Encoding' => 'binary',
            'Pragma' => 'public',
        ]);

        return $response;
    }

    /**
     * @param string $content
     * @param string $filename
     * @return Response
     */
    public static function setZipFileResponse(string $content, string $filename)
    {
        $stream = new Stream($content, 'r');
        $fileSize = $stream->getSize();

        $response = new Response($stream, Http::STATUS_CODE_HTTP_OK, [
            Http::HEADER_CONTENT_TYPE => Http::CONTENT_TYPE_APPLICATION_ZIP_OCTET_STREAM,

            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => $fileSize,
            'Content-Transfer-Encoding' => 'binary',
            'Pragma' => 'public',
        ]);

        return $response;
    }

    /**
     * @param ResponseInterface $response
     * @param string $body
     */
    public static function setSvgResponse(ResponseInterface &$response, string $body)
    {
        self::addContentTypeSvgXmlHeader($response);
        $response->getBody()->write($body);
    }

    /**
     * @param ResponseInterface $response
     * @return array|mixed
     */
    public static function getJsonContentFromResponse(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();

        if (!$content) {
            return [];
        }

        return \json_decode($content, true);
    }
}