<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Search\Result;

use DataProvider\ElasticsearchResultSetDataProvider;
use Elastica\ResultSet;

interface ResultSetConverterInterface
{
    /**
     * @param \Elastica\ResultSet $resultSet
     *
     * @return \DataProvider\ElasticsearchResultSetDataProvider
     */
    public function convertResult(ResultSet $resultSet): ElasticsearchResultSetDataProvider;
}