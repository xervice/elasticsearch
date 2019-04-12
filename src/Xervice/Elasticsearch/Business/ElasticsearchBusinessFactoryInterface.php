<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business;


use Elastica\Client;
use Xervice\Elasticsearch\Business\Collection\IndexCollection;
use Xervice\Elasticsearch\Business\Model\Document\DocumentBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Document\DocumentCleanerInterface;
use Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Index\MappingConverterInterface;
use Xervice\Elasticsearch\Business\Model\IndexerInterface;
use Xervice\Elasticsearch\Business\Model\Search\Query\QueryBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Search\Result\ResultSetConverterInterface;
use Xervice\Elasticsearch\Business\Model\Search\SearchInterface;

/**
 * @method \Xervice\Elasticsearch\ElasticsearchConfig getConfig()
 */
interface ElasticsearchBusinessFactoryInterface
{
    /**
     * @param array $queryExtenderPlugins
     * @param array $resultFormatterPlugins
     *
     * @return \Xervice\Elasticsearch\Business\Model\Search\SearchInterface
     */
    public function createSearch(array $queryExtenderPlugins, array $resultFormatterPlugins): SearchInterface;

    /**
     * @param array $queryExtenderPlugins
     *
     * @return \Xervice\Elasticsearch\Business\Model\Search\Query\QueryBuilderInterface
     */
    public function createQueryBuilder(array $queryExtenderPlugins): QueryBuilderInterface;

    /**
     * @param array $resultFormatterPlugins
     *
     * @return \Xervice\Elasticsearch\Business\Model\Search\Result\ResultSetConverterInterface
     */
    public function createResultSetConverter(array $resultFormatterPlugins): ResultSetConverterInterface;

    /**
     * @return \Xervice\Elasticsearch\Business\Model\Document\DocumentCleanerInterface
     */
    public function createDocumentCleaner(): DocumentCleanerInterface;

    /**
     * @return \Xervice\Elasticsearch\Business\Model\Document\DocumentBuilderInterface
     */
    public function createDocumentBuilder(): DocumentBuilderInterface;

    /**
     * @return \Xervice\Elasticsearch\Business\Model\IndexerInterface
     */
    public function createIndexer(): IndexerInterface;

    /**
     * @return \Xervice\Elasticsearch\Business\Model\Index\MappingConverterInterface
     */
    public function createMappingConverter(): MappingConverterInterface;

    /**
     * @return \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface
     */
    public function createIndexBuilder(): IndexBuilderInterface;

    /**
     * @return \Elastica\Client
     */
    public function getClient(): Client;

    /**
     * @return \Xervice\Elasticsearch\Business\Collection\IndexCollection
     */
    public function getIndexProviderCollection(): IndexCollection;
}