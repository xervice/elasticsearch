<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Dependency\Plugin;


use Elastica\Query;

interface QueryExtenderPluginInterface
{
    /**
     * @param \Elastica\Query $query
     *
     * @return \Elastica\Query
     */
    public function extendQuery(Query $query): Query;
}