<?php
declare(strict_types=1);

namespace XerviceTest\Elasticsearch\Integration\Index;


use DataProvider\ElasticSearchTestDataProvider;
use DataProvider\IndexDataProvider;
use DataProvider\TypeDataProvider;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Index\MappingConverterInterface;
use Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface;

class TestIndexProviderWithTypes implements IndexProviderInterface
{
    /**
     * @param \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface $indexBuilder
     */
    public function createIndex(IndexBuilderInterface $indexBuilder, MappingConverterInterface $mappingConverter): void
    {
        $type = (new TypeDataProvider())
            ->setName('testtype')
            ->setMapping(
                $mappingConverter->convertToMapping(ElasticSearchTestDataProvider::class)
            );

        $index = (new IndexDataProvider())
            ->setName('unittest')
            ->setArguments(
                [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1
                ]
            )
            ->setDelete(true)
            ->addType($type);

        $indexBuilder->createIndex($index);
    }
}