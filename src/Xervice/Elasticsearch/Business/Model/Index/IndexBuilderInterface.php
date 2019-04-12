<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Index;

use DataProvider\IndexDataProvider;

interface IndexBuilderInterface
{
    /**
     * @param \DataProvider\IndexDataProvider $indexDataProvider
     */
    public function createIndex(IndexDataProvider $indexDataProvider): void;
}