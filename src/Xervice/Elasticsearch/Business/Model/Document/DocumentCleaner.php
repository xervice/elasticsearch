<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Document;


use DataProvider\DocumentListDataProvider;
use Elastica\Client;
use Elastica\Document;

class DocumentCleaner implements DocumentCleanerInterface
{
    /**
     * @var \Elastica\Client
     */
    private $client;

    /**
     * DocumentBuilder constructor.
     *
     * @param \Elastica\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param \DataProvider\DocumentListDataProvider $listDataProvider
     */
    public function deleteDocuments(DocumentListDataProvider $listDataProvider): void
    {
        $documents = $this->getDocumentsFromDataProvider($listDataProvider);

        $type = $this
            ->client
            ->getIndex($listDataProvider->getIndex())
            ->getType($listDataProvider->getType());

        $type->deleteDocuments($documents);

        $type->getIndex()->refresh();
    }

    /**
     * @param \DataProvider\DocumentListDataProvider $listDataProvider
     * @param array $document
     *
     * @return array
     */
    protected function getDocumentsFromDataProvider(DocumentListDataProvider $listDataProvider): array
    {
        $documents = [];

        foreach ($listDataProvider->getDocuments() as $documentDataProvider) {
            $documents[] = new Document(
                $documentDataProvider->getIdent(),
                $documentDataProvider->getContent()
            );
        }

        return $documents;
    }
}