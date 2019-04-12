<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Dependency\Plugin;


use Xervice\Elasticsearch\Business\Model\Document\DocumentBuilderInterface;

interface DocumentBuilderPlugin
{
    /**
     * @param \Xervice\Elasticsearch\Business\Model\Document\DocumentBuilderInterface $documentBuilder
     */
    public function createDocuments(DocumentBuilderInterface $documentBuilder): void;
}