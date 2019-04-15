<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Index;


use DataProvider\IndexDataProvider;
use Elastica\Client;
use Elastica\Index;
use Elastica\Type\Mapping;

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
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param \DataProvider\IndexDataProvider $indexDataProvider
     */
    public function createIndex(IndexDataProvider $indexDataProvider): void
    {
        $index = $this->client->getIndex($indexDataProvider->getName());

        if (!$index->exists() || $indexDataProvider->getDelete()) {
            $index->create(
                $indexDataProvider->getArguments(),
                $indexDataProvider->getDelete()
            );
        }

        $this->createTypes($index, $indexDataProvider->getTypes());
    }

    /**
     * @param \Elastica\Index $index
     * @param \DataProvider\TypeDataProvider[] $types
     */
    protected function createTypes(Index $index, array $types): void
    {
        foreach ($types as $type) {
            $esType = $index->getType($type->getName());

            $mapping = new Mapping();
            $mapping->setType($esType);

            $mapping->setProperties($type->getMapping());

            $mapping->send();
        }
    }
}