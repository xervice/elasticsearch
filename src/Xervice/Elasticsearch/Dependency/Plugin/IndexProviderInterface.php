<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Dependency\Plugin;


use Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface;

interface IndexProviderInterface
{
    /**
     * @param \Xervice\Elasticsearch\Business\Model\Index\IndexBuilderInterface $indexBuilder
     */
    public function createIndex(IndexBuilderInterface $indexBuilder): void;
}