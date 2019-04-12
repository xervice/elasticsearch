<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Search\Query;

use Elastica\Query;

interface QueryBuilderInterface
{
    /**
     * @param \Elastica\Query $query
     *
     * @return \Elastica\Query
     */
    public function getQuery(Query $query): Query;
}