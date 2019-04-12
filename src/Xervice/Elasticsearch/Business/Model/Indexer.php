<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model;


use Elastica\Client;
use Xervice\Elasticsearch\Business\Collection\IndexCollection;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface;

class Indexer implements IndexerInterface
{
    /**
     * @var \Xervice\Elasticsearch\Business\Collection\IndexCollection
     */
    private $indexCollection;

    /**
     * @var \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface
     */
    private $indexBuilder;

    /**
     * Indexer constructor.
     *
     * @param \Xervice\Elasticsearch\Business\Collection\IndexCollection $indexCollection
     * @param \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface $indexBuilder
     */
    public function __construct(
        IndexCollection $indexCollection,
        IndexBuilderInterface $indexBuilder
    ) {
        $this->indexCollection = $indexCollection;
        $this->indexBuilder = $indexBuilder;
    }

    public function createIndizes(): void
    {
        foreach ($this->indexCollection as $indexProvider) {
            $indexProvider->createIndex($this->indexBuilder);
        }
    }
}
