<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Document;

use DataProvider\DocumentListDataProvider;

interface DocumentBuilderInterface
{
    /**
     * @param \DataProvider\DocumentListDataProvider $listDataProvider
     */
    public function createDocuments(DocumentListDataProvider $listDataProvider): void;
}