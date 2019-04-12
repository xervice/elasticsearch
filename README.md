# Elasticsearch

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xervice/elasticsearch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xervice/elasticsearch/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/xervice/elasticsearch/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/xervice/elasticsearch/?branch=master)

## Installation
```
composer require xervice/elasticsearch:^1.0.0
```

## Configuration
*Your config*
```php
    use Xervice\Elasticsearch\ElasticsearchConfig;

    $config[ElasticsearchConfig::HOST] = '127.0.0.1';
    $config[ElasticsearchConfig::PORT] = 9200;
```

*Define Index*
```php
# Overwrite ElasticSearchDependencyProvider and add your IndexProvider 

    /**
     * @return \Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface[]
     */
    protected function getIndexProvider(): array
    {
        return [
            new CustomIndexProvider
        ];
    }
    
    
### Your Index-Provider must implement IndexProviderInterface and define your index and types 
    /**
     * @param \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface $indexBuilder
     */
    public function createIndex(IndexBuilderInterface $indexBuilder, MappingConverterInterface $mappingConverter): void
    {
        $type = (new TypeDataProvider())
            ->setName('customtype')
            ->setMapping(
                $mappingConverter->convertToMapping(ElasticSearchTestDataProvider::class)
            );

        $index = (new IndexDataProvider())
            ->setName('customindex')
            ->setArguments(
                [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1
                ]
            )
            ->setDelete(false)
            ->addType($type);

        $indexBuilder->createIndex($index);
    }

```

##Using
*Create documents*
````php
    $documentList = (new DocumentListDataProvider())
        ->setIndex('testindex')
        ->setType('testtype')
        ->addDocument(
            (new DocumentDataProvider())
                ->setIdent(1)
                ->setContent($customDataProvider->toArray())
        );

    $this->getFacade()->createDocuments($documentList);
````

*Search documents*
```php
    $textQuery = new QueryString('SearchKey');
    $boolQuery = new BoolQuery();
    $boolQuery->addMust($textQuery);

    $query = new Query($boolQuery);

    $result = $this->getFacade()->search('testindex', $query, [], []);
```

## Extended Search

You can define your own QueryExtender and ResultFormatter and add them to your Search:

```php
$result = $this->getFacade()->search(
    'testindex', 
    $query, 
    [
        new CustomSearchExtenderPlugin()
    ], 
    [
        new CustomResultFormatterPlugin()
    ]
);
```
