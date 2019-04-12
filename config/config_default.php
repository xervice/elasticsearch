<?php

use Xervice\DataProvider\DataProviderConfig;
use Xervice\Elasticsearch\ElasticsearchConfig;

if (class_exists(DataProviderConfig::class)) {
    $config[DataProviderConfig::DATA_PROVIDER_GENERATED_PATH] = dirname(__DIR__) . '/src/Generated';
    $config[DataProviderConfig::DATA_PROVIDER_PATHS] = [
        dirname(__DIR__) . '/src/'
    ];
}

// Elasticsearch
if (class_exists(ElasticsearchConfig::class)) {
    $config[ElasticsearchConfig::HOST] = '127.0.0.1';
    $config[ElasticsearchConfig::PORT] = 9200;
}