<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Index;


use DataProvider\IndexDataProvider;

class IndexBuilder implements IndexBuilderInterface
{
    /**
     * @var \Elastica\Client
     */
    private $client;

    /**
     * IndexBuilder constructor.
     *
     * @param \Elastica\Client $client
     */
    public function __construct(\Elastica\Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param \DataProvider\IndexDataProvider $indexDataProvider
     */
    public function createIndex(IndexDataProvider $indexDataProvider): void
    {
        $index = $this->client->getIndex($indexDataProvider->getName());

        $index->create(
            $indexDataProvider->getArguments(),
            $indexDataProvider->getDelete()
        );
    }
}