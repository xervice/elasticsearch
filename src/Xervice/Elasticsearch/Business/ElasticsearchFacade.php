<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business;


use DataProvider\DocumentListDataProvider;
use DataProvider\ElasticsearchResultSetDataProvider;
use DataProvider\SearchDataProvider;
use Elastica\Query;
use Elastica\ResultSet;
use Xervice\Core\Business\Model\Facade\AbstractFacade;
use Xervice\Elasticsearch\Dependency\Plugin\DocumentBuilderPlugin;

/**
 * @method \Xervice\Elasticsearch\Business\ElasticsearchBusinessFactory getFactory()
 * @method \Xervice\Elasticsearch\ElasticsearchConfig getConfig()
 */
class ElasticsearchFacade extends AbstractFacade
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