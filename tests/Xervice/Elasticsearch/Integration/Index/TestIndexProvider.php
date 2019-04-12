<?php
declare(strict_types=1);

namespace XerviceTest\Elasticsearch\Integration\Index;


use DataProvider\IndexDataProvider;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface;
use Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface;

class TestIndexProvider implements IndexProviderInterface
{
    /**
     * @param \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface $indexBuilder
     */
    public function createIndex(IndexBuilderInterface $indexBuilder): void
    {
        $index = (new IndexDataProvider())
            ->setName('unittest')
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