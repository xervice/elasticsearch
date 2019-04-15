<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business;


use DataProvider\DocumentListDataProvider;
use DataProvider\ElasticsearchResultSetDataProvider;
use Elastica\Query;

/**
 * @method \Xervice\Elasticsearch\Business\ElasticsearchBusinessFactory getFactory()
 * @method \Xervice\Elasticsearch\ElasticsearchConfig getConfig()
 */
interface ElasticsearchFacadeInterface
{
    /**
     * Generate all indizes in elasticsearch
     *
     * @api
     */
    public function createIndizes(): void;

    /**
     * Create a list of documents in elasticsearch
     *
     * @param \DataProvider\DocumentListDataProvider $listDataProvider
     *
     * @api
     *
     */
    public function createDocuments(DocumentListDataProvider $listDataProvider): void;

    /**
     * Remove a list of documents in elasticsearch
     *
     * @param \DataProvider\DocumentListDataProvider $listDataProvider
     *
     * @api
     *
     */
    public function deleteDocuments(DocumentListDataProvider $listDataProvider): void;

    /**
     * Send search request to elasticsearch
     * QueryExtenderPlugins can extend the query
     * ResultFormatterPlugins can format the result DataProvider
     *
     * @param string $index
     * @param \Elastica\Query $query
     * @param array $queryExtender
     * @param array $resultFormatter
     *
     * @return \DataProvider\ElasticsearchResultSetDataProvider
     * @api
     *
     */
    public function search(string $index, Query $query, array $queryExtender = [], array $resultFormatter = []
    ): ElasticsearchResultSetDataProvider;

    /**
     * @param string $dataProviderClass
     *
     * @return array
     */
    public function getMapping(string $dataProviderClass): array;
}