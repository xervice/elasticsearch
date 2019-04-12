<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business;


use DataProvider\DocumentListDataProvider;
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
}