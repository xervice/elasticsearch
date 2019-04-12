<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model;


use Elastica\Client;
use Xervice\Elasticsearch\Business\Collection\IndexCollection;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Index\MappingConverterInterface;

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
     * @var \Xervice\Elasticsearch\Business\Model\Index\MappingConverterInterface
     */
    private $mappingConverter;

    /**
     * Indexer constructor.
     *
     * @param \Xervice\Elasticsearch\Business\Collection\IndexCollection $indexCollection
     * @param \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface $indexBuilder
     */
    public function __construct(
        IndexCollection $indexCollection,
        IndexBuilderInterface $indexBuilder,
        MappingConverterInterface $mappingConverter
    ) {
        $this->indexCollection = $indexCollection;
        $this->indexBuilder = $indexBuilder;
        $this->mappingConverter = $mappingConverter;
    }

    public function createIndizes(): void
    {
        foreach ($this->indexCollection as $indexProvider) {
            $indexProvider->createIndex(
                $this->indexBuilder,
                $this->mappingConverter
            );
        }
    }
}
