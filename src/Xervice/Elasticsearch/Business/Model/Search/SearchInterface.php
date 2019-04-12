<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Search;

use DataProvider\ElasticsearchResultSetDataProvider;
use Elastica\Query;

interface SearchInterface
{
    /**
     * @param string $index
     * @param \Elastica\Query $query
     *
     * @return \DataProvider\ElasticsearchResultSetDataProvider
     */
    public function search(string $index, Query $query): ElasticsearchResultSetDataProvider;
}