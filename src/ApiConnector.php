<?php

declare(strict_types=1);

namespace Baltyre\B2BClient;

use Baltyre\B2BClient\Curl\Factory;
use Baltyre\B2BClient\Exception\ConnectionException;
use Baltyre\B2BClient\Exception\NotAllowedException;
use Baltyre\B2BClient\Exception\NotFoundException;
use Baltyre\B2BClient\Exception\NotSupportedException;
use Baltyre\B2BClient\Exception\ServerException;
use Baltyre\B2BClient\Exception\UnauthorizedAccessException;

class ApiConnector
{
    private const METHOD_GET = "GET";
    private const METHOD_PUT = "PUT";
    private const METHOD_POST = "POST";
    private string $baseUrl;
    private string $token;
    private ?string $debugDir;

    public function __construct(string $baseUrl, string $token, string $debugDir = null)
    {
        $this->baseUrl = $baseUrl;
        $this->token = $token;
        $this->debugDir = $debugDir;
    }

    /**
     * @throws ConnectionException
     * @throws Exception\BadRequestException
     * @throws NotAllowedException
     * @throws NotFoundException
     * @throws NotSupportedException
     * @throws ServerException
     * @throws UnauthorizedAccessException
     */
    public function get(string $path): mixed
    {
        return $this->send($path);
    }

    /**
     * @throws ConnectionException
     * @throws Exception\BadRequestException
     * @throws NotAllowedException
     * @throws NotFoundException
     * @throws NotSupportedException
     * @throws ServerException
     * @throws UnauthorizedAccessException
     */
    public function put(string $path, mixed $body): mixed
    {
        return $this->send($path, self::METHOD_PUT, $body);
    }

    /**
     * @throws ConnectionException
     * @throws Exception\BadRequestException
     * @throws NotAllowedException
     * @throws NotFoundException
     * @throws NotSupportedException
     * @throws ServerException
     * @throws UnauthorizedAccessException
     */
    public function post(string $path, mixed $body): mixed
    {
        return $this->send($path, self::METHOD_POST, $body);
    }

    /**
     * @throws ConnectionException
     * @throws Exception\BadRequestException
     * @throws NotAllowedException
     * @throws NotFoundException
     * @throws NotSupportedException
     * @throws ServerException
     * @throws UnauthorizedAccessException
     */
    private function send(string $path, string $method = self::METHOD_GET, mixed $requestBody = null): mixed
    {
        $client = Factory::createClient();
        $request = Factory::createRequest($method, $this->baseUrl . "/" . $path);

        if ($this->token) {
            $request = $request->withHeader("X-Api-Key", $this->token);
        }
        if ($requestBody !== null) {
            $request = $request->withBody(json_encode($requestBody));
        }

        $response = $client->sendRequest($request);

        $responseStatus = $response->getStatusCode();
        $responseBody = $response->getBody();

        if ($this->debugDir) {
            file_put_contents($this->debugDir . "/" . $path . ".json", $responseBody);
        }

        $responseObject = json_decode($responseBody);
        if ($error = json_last_error()) {
            throw new ConnectionException(json_last_error_msg(), $error);
        }

        if ($responseStatus === 200) {
            return $responseObject;
        }
        if ($responseStatus === 401) {
            throw new UnauthorizedAccessException($responseObject->message, $responseObject->code);
        }
        if ($responseStatus === 404) {
            throw new NotFoundException($responseObject->message, $responseObject->code);
        }
        if ($responseStatus === 405) {
            throw new NotAllowedException($responseObject->message, $responseObject->code);
        }
        if ($responseStatus === 462) {
            throw new NotSupportedException($responseObject->message, $responseObject->code);
        }
        if ($responseStatus === 500) {
            throw new ServerException($responseObject->message, $responseObject->code);
        }
        throw new ConnectionException("An error occurred during communication");
    }
}