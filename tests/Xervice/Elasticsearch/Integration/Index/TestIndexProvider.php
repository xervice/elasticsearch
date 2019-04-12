<?php
declare(strict_types=1);

namespace XerviceTest\Elasticsearch\Integration\Index;


use DataProvider\IndexDataProvider;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Index\MappingConverterInterface;
use Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface;

class TestIndexProvider implements IndexProviderInterface
{
    /**
     * @param \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface $indexBuilder
     * @param \Xervice\Elasticsearch\Business\Model\Index\MappingConverterInterface $mappingConverter
     */
    public function createIndex(IndexBuilderInterface $indexBuilder, MappingConverterInterface $mappingConverter): void
    {
        $index = (new IndexDataProvider())
            ->setName('testindex')
            ->setArguments(
                [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1
                ]
            )
            ->setDelete(true);

        $indexBuilder->createIndex($index);
    }
}