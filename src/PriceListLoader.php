<?php

declare(strict_types=1);

namespace Baltyre\B2BClient;

use Baltyre\B2BClient\Dto\PriceListCollection;

class PriceListLoader
{
    private const RESOURCE = "pricelist";
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
    public function load(): PriceListCollection
    {
        return PriceListCollection::fromApi($this->connector->get(self::RESOURCE));
    }
}