<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Search\Query;


use Elastica\Query;

class QueryBuilder implements QueryBuilderInterface
{
    /**
     * @var \Xervice\Elasticsearch\Dependency\Plugin\QueryExtenderPluginInterface[]
     */
    private $queryExtenderPlugins;

    /**
     * QueryBuilder constructor.
     *
     * @param \Xervice\Elasticsearch\Dependency\Plugin\QueryExtenderPluginInterface[] $queryExtenderPlugins
     */
    public function __construct(array $queryExtenderPlugins)
    {
        $this->queryExtenderPlugins = $queryExtenderPlugins;
    }

    /**
     * @param \Elastica\Query $query
     *
     * @return \Elastica\Query
     */
    public function getQuery(Query $query): Query
    {
        foreach ($this->queryExtenderPlugins as $extenderPlugin) {
            $query = $extenderPlugin->extendQuery($query);
        }

        return $query;
    }
}