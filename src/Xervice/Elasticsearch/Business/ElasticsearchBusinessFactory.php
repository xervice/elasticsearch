<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business;


use Elastica\Client;
use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;
use Xervice\Elasticsearch\Business\Collection\IndexCollection;
use Xervice\Elasticsearch\Business\Model\Document\DocumentBuilder;
use Xervice\Elasticsearch\Business\Model\Document\DocumentBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Document\DocumentCleaner;
use Xervice\Elasticsearch\Business\Model\Document\DocumentCleanerInterface;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilder;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Index\MappingConverter;
use Xervice\Elasticsearch\Business\Model\Index\MappingConverterInterface;
use Xervice\Elasticsearch\Business\Model\Indexer;
use Xervice\Elasticsearch\Business\Model\IndexerInterface;
use Xervice\Elasticsearch\Business\Model\Search\Query\QueryBuilder;
use Xervice\Elasticsearch\Business\Model\Search\Query\QueryBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Search\Result\ResultSetConverter;
use Xervice\Elasticsearch\Business\Model\Search\Result\ResultSetConverterInterface;
use Xervice\Elasticsearch\Business\Model\Search\Search;
use Xervice\Elasticsearch\Business\Model\Search\SearchInterface;
use Xervice\Elasticsearch\ElasticsearchDependencyProvider;

/**
 * @method \Xervice\Elasticsearch\ElasticsearchConfig getConfig()
 */
class ElasticsearchBusinessFactory extends AbstractBusinessFactory implements ElasticsearchBusinessFactoryInterface
{
    /**
     * @param array $queryExtenderPlugins
     * @param array $resultFormatterPlugins
     *
     * @return \Xervice\Elasticsearch\Business\Model\Search\SearchInterface
     */
    public function createSearch(
        array $queryExtenderPlugins,
        array $resultFormatterPlugins
    ): SearchInterface {
        return new Search(
            $this->getClient(),
            $this->createQueryBuilder($queryExtenderPlugins),
            $this->createResultSetConverter($resultFormatterPlugins)
        );
    }

    /**
     * @param array $queryExtenderPlugins
     *
     * @return \Xervice\Elasticsearch\Business\Model\Search\Query\QueryBuilderInterface
     */
    public function createQueryBuilder(array $queryExtenderPlugins): QueryBuilderInterface
    {
        return new QueryBuilder(
            $queryExtenderPlugins
        );
    }

    /**
     * @param array $resultFormatterPlugins
     *
     * @return \Xervice\Elasticsearch\Business\Model\Search\Result\ResultSetConverterInterface
     */
    public function createResultSetConverter(array $resultFormatterPlugins): ResultSetConverterInterface
    {
        return new ResultSetConverter(
            $resultFormatterPlugins
        );
    }

    /**
     * @return \Xervice\Elasticsearch\Business\Model\Document\DocumentCleanerInterface
     */
    public function createDocumentCleaner(): DocumentCleanerInterface
    {
        return new DocumentCleaner(
            $this->getClient()
        );
    }

    /**
     * @return \Xervice\Elasticsearch\Business\Model\Document\DocumentBuilderInterface
     */
    public function createDocumentBuilder(): DocumentBuilderInterface
    {
        return new DocumentBuilder(
            $this->getClient()
        );
    }

    /**
     * @return \Xervice\Elasticsearch\Business\Model\IndexerInterface
     */
    public function createIndexer(): IndexerInterface
    {
        return new Indexer(
            $this->getIndexProviderCollection(),
            $this->createIndexBuilder(),
            $this->createMappingConverter()
        );
    }

    /**
     * @return \Xervice\Elasticsearch\Business\Model\Index\MappingConverterInterface
     */
    public function createMappingConverter(): MappingConverterInterface
    {
        return new MappingConverter();
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