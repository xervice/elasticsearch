<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Search\Result;


use DataProvider\ElasticSearchRawResultDataProvider;
use DataProvider\ElasticsearchResultSetDataProvider;
use Elastica\ResultSet;
use Xervice\Elasticsearch\Dependency\Plugin\ResultFormatterPluginInterface;

class ResultSetConverter implements ResultSetConverterInterface
{
    /**
     * @var \Xervice\Elasticsearch\Dependency\Plugin\ResultFormatterPluginInterface[]
     */
    private $formatterPlugins;

    /**
     * ResultSetConverter constructor.
     *
     * @param array $formatterPlugins
     */
    public function __construct(array $formatterPlugins)
    {
        $this->formatterPlugins = $formatterPlugins;
    }

    /**
     * @param \Elastica\ResultSet $resultSet
     *
     * @return \DataProvider\ElasticsearchResultSetDataProvider
     */
    public function convertResult(ResultSet $resultSet): ElasticsearchResultSetDataProvider
    {
        $result = (new ElasticsearchResultSetDataProvider())
            ->setTotalHits($resultSet->getTotalHits())
            ->setTotalTime($resultSet->getTotalTime())
            ->setMaxScore($resultSet->getMaxScore())
            ->setRawResults(
                (new ElasticSearchRawResultDataProvider())
                    ->setDocuments($resultSet->getDocuments())
                    ->setAggregations($resultSet->getAggregations())
                    ->setSuggests($resultSet->getSuggests())
                    ->setResults($resultSet->getResults())
            );

        return $this->loopFormatterPlugins($result);
    }

    /**
     * @param \DataProvider\ElasticsearchResultSetDataProvider $resultSetDataProvider
     *
     * @return \DataProvider\ElasticsearchResultSetDataProvider
     */
    protected function loopFormatterPlugins(
        ElasticsearchResultSetDataProvider $resultSetDataProvider
    ): ElasticsearchResultSetDataProvider {
        foreach ($this->formatterPlugins as $formatterPlugin) {
            $resultSetDataProvider = $formatterPlugin->formatResult($resultSetDataProvider);
        }

        return $resultSetDataProvider;
    }
}