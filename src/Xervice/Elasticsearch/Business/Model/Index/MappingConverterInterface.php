<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Index;

interface MappingConverterInterface
{
    /**
     * @param string $dataProvider
     *
     * @return array
     */
    public function convertToMapping(string $dataProvider): array;
}