<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Curl;

use Baltyre\B2BClient\Exception\BadRequestException;
use Baltyre\B2BClient\Exception\ConnectionException;
use CurlHandle;

class Client
{
    private ?CurlHandle $handle = null;

    /**
     * @throws ConnectionException
     * @throws BadRequestException
     */
    public function sendRequest(Request $request): Response
    {
        if ($this->handle) {
            curl_reset($this->handle);
        } else {
            $this->handle = curl_init();
        }

        curl_setopt($this->handle, CURLOPT_URL, $request->getUri());
        curl_setopt($this->handle, CURLOPT_HEADER, false);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, false);

        $headers = [];
        foreach ($request->getHeaders() as $header => $values) {
            foreach ($values as $value) {
                $headers[] = $header . ": " . $value;
            }
        }
        if ($headers) {
            curl_setopt($this->handle, CURLOPT_HTTPHEADER, $headers);
        }
        if ($request->getBody()) {
            curl_setopt($this->handle, CURLOPT_POSTFIELDS, $request->getBody());
        }

        if ($request->getMethod() === "HEAD") {
            curl_setopt($this->handle, CURLOPT_NOBODY, true);
        } elseif ($request->getMethod() !== "GET") {
            curl_setopt($this->handle, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        }

        $response = new Response();

        curl_setopt($this->handle, CURLOPT_HEADERFUNCTION, function ($ch, $data) use ($response) {
            $str = trim($data);
            if ($str !== "") {
                if (stripos($str, "http/") === 0) {
                    $response->setStatus($str);
                } else {
                    $response->addHeader($str);
                }
            }
            return strlen($data);
        });

        curl_setopt($this->handle, CURLOPT_WRITEFUNCTION, function ($ch, $data) use ($response) {
            $response->writeBody($data);
            return strlen($data);
        });

        curl_exec($this->handle);

        $errno = curl_errno($this->handle);
        switch ($errno) {
            case CURLE_OK:
                break;
            case CURLE_COULDNT_RESOLVE_PROXY:
                throw new ConnectionException(curl_error($this->handle));
            case CURLE_COULDNT_RESOLVE_HOST:
                throw new ConnectionException(curl_error($this->handle));
            case CURLE_COULDNT_CONNECT:
                throw new ConnectionException(curl_error($this->handle));
            case CURLE_OPERATION_TIMEOUTED:
                throw new ConnectionException(curl_error($this->handle));
            case CURLE_SSL_CONNECT_ERROR:
                throw new ConnectionException(curl_error($this->handle));
            default:
                throw new BadRequestException(curl_error($this->handle));
        }

        return $response;
    }

    public function __destruct()
    {
        if ($this->handle) {
            curl_close($this->handle);
        }
    }
}