<?php

declare(strict_types=1);

namespace Baltyre\B2BClient;

use Baltyre\B2BClient\Dto\ProductCollection;

class CatalogLoader
{
    private const RESOURCE = "catalog";
    private ApiConnector $connector;

    public function __construct(ApiConnector $connection)
    {
        $this->connector = $connection;
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
    public function load(): ProductCollection
    {
        return ProductCollection::fromApi($this->connector->get(self::RESOURCE));
    }
}