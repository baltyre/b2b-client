<?php

declare(strict_types=1);

namespace Baltyre\B2BClient;

use Baltyre\B2BClient\Dto\StockCollection;

class StockLoader
{
    private const RESOURCE = "stock";
    private ApiConnector $connector;

    public function __construct(ApiConnector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @throws Exception\BadRequestException
     * @throws Exception\ConnectionException
     * @throws Exception\NotAllowedException
     * @throws Exception\NotFoundException
     * @throws Exception\NotSupportedException
     * @throws Exception\ServerException
     * @throws Exception\UnauthorizedAccessException
     */
    public function load(): StockCollection
    {
        return StockCollection::fromApi($this->connector->get(self::RESOURCE));
    }
}