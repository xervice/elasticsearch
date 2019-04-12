<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Dependency\Plugin;


use DataProvider\ElasticsearchResultSetDataProvider;

interface ResultFormatterPluginInterface
{
    /**
     * @param \DataProvider\ElasticsearchResultSetDataProvider $resultSetDataProvider
     *
     * @return \DataProvider\ElasticsearchResultSetDataProvider
     */
    public function formatResult(ElasticsearchResultSetDataProvider $resultSetDataProvider): ElasticsearchResultSetDataProvider;
}