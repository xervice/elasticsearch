<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Search;


use DataProvider\ElasticsearchResultSetDataProvider;
use Elastica\Client;
use Elastica\Query;
use Elastica\Search as ElasticaSearch;
use Xervice\Elasticsearch\Business\Model\Search\Query\QueryBuilderInterface;
use Xervice\Elasticsearch\Business\Model\Search\Result\ResultSetConverterInterface;

class Search implements SearchInterface
{
    /**
     * @var \Elastica\Client
     */
    private $client;

    /**
     * @var \Xervice\Elasticsearch\Business\Model\Search\Query\QueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var \Xervice\Elasticsearch\Business\Model\Search\Result\ResultSetConverterInterface
     */
    private $resultConverter;

    /**
     * Search constructor.
     *
     * @param \Elastica\Client $client
     * @param \Xervice\Elasticsearch\Business\Model\Search\Query\QueryBuilderInterface $queryBuilder
     * @param \Xervice\Elasticsearch\Business\Model\Search\Result\ResultSetConverterInterface $resultConverter
     */
    public function __construct(
        Client $client,
        QueryBuilderInterface $queryBuilder,
        ResultSetConverterInterface $resultConverter
    ) {
        $this->client = $client;
        $this->queryBuilder = $queryBuilder;
        $this->resultConverter = $resultConverter;
    }


    /**
     * @param string $index
     * @param \Elastica\Query $query
     *
     * @return \DataProvider\ElasticsearchResultSetDataProvider
     */
    public function search(string $index, Query $query): ElasticsearchResultSetDataProvider
    {
        $search = new ElasticaSearch(
            $this->client
        );

        return $this->resultConverter->convertResult(
            $search->addIndex($index)->search(
                $this->queryBuilder->getQuery(
                    $query
                )
            )
        );
    }

}