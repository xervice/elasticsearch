<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model;

interface IndexerInterface
{
    public function createIndizes(): void;
}