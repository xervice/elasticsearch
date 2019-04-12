<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Document;

use DataProvider\DocumentListDataProvider;

interface DocumentCleanerInterface
{
    /**
     * @param \DataProvider\DocumentListDataProvider $listDataProvider
     */
    public function deleteDocuments(DocumentListDataProvider $listDataProvider): void;
}