<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business;


use Elastica\Client;
use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;
use Xervice\Elasticsearch\Business\Collection\IndexCollection;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilder;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Indexer;
use Xervice\Elasticsearch\Business\Model\IndexerInterface;
use Xervice\Elasticsearch\ElasticsearchDependencyProvider;

/**
 * @method \Xervice\Elasticsearch\ElasticsearchConfig getConfig()
 */
class ElasticsearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Xervice\Elasticsearch\Business\Model\IndexerInterface
     */
    public function createIndexer(): IndexerInterface
    {
        return new Indexer(
            $this->getIndexProviderCollection(),
            $this->createIndexBuilder()
        );
    }

    /**
     * @return \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface
     */
    public function createIndexBuilder(): IndexBuilderInterface
    {
        return new IndexBuilder(
            $this->getClient()
        );
    }

    /**
     * @return \Elastica\Client
     */
    public function getClient(): Client
    {
        return $this->getDependency(ElasticsearchDependencyProvider::CLIENT);
    }

    /**
     * @return \Xervice\Elasticsearch\Business\Collection\IndexCollection
     */
    public function getIndexProviderCollection(): IndexCollection
    {
        return $this->getDependency(ElasticsearchDependencyProvider::INDEX_PROVIDER);
    }
}