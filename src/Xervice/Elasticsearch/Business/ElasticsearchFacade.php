<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business;


use Xervice\Core\Business\Model\Facade\AbstractFacade;

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
        $this->getFactory()->createIndexer()->createIndizes();
    }
}