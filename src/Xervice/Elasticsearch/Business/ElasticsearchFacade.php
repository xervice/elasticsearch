<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business;


use DataProvider\DocumentListDataProvider;
use DataProvider\ElasticsearchResultSetDataProvider;
use Elastica\Query;
use Xervice\Core\Business\Model\Facade\AbstractFacade;
use Xervice\DataProvider\Business\Model\DataProvider\DataProviderInterface;

/**
 * @method \Xervice\Elasticsearch\Business\ElasticsearchBusinessFactory getFactory()
 * @method \Xervice\Elasticsearch\ElasticsearchConfig getConfig()
 */
class ElasticsearchFacade extends AbstractFacade implements ElasticsearchFacadeInterface
{
    /**
     * Generate all indizes in elasticsearch
     *
     * @api
     */
    public function createIndizes(): void
    {
        $this
            ->getFactory()
            ->createIndexer()
            ->createIndizes();
    }

    /**
     * @param string $dataProviderClass
     *
     * @return array
     */
    public function getMapping(string $dataProviderClass): array
    {
        return $this
            ->getFactory()
            ->createMappingConverter()
            ->convertToMapping($dataProviderClass);
    }

    /**
     * Create a list of documents in elasticsearch
     *
     * @api
     *
     * @param \DataProvider\DocumentListDataProvider $listDataProvider
     */
    public function createDocuments(DocumentListDataProvider $listDataProvider): void
    {
        $this
            ->getFactory()
            ->createDocumentBuilder()
            ->createDocuments($listDataProvider);
    }

    /**
     * Remove a list of documents in elasticsearch
     *
     * @api
     *
     * @param \DataProvider\DocumentListDataProvider $listDataProvider
     */
    public function deleteDocuments(DocumentListDataProvider $listDataProvider): void
    {
        $this
            ->getFactory()
            ->createDocumentCleaner()
            ->deleteDocuments($listDataProvider);
    }

    /**
     * Send search request to elasticsearch
     * QueryExtenderPlugins can extend the query
     * ResultFormatterPlugins can format the result DataProvider
     *
     * @api
     *
     * @param string $index
     * @param \Elastica\Query $query
     * @param array $queryExtender
     * @param array $resultFormatter
     *
     * @return \DataProvider\ElasticsearchResultSetDataProvider
     */
    public function search(
        string $index,
        Query $query,
        array $queryExtender = [],
        array $resultFormatter = []
    ): ElasticsearchResultSetDataProvider {
        return $this
            ->getFactory()
            ->createSearch($queryExtender, $resultFormatter)
            ->search($index, $query);
    }
}