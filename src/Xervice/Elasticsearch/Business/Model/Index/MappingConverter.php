<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Model\Index;


class MappingConverter implements MappingConverterInterface
{
    /**
     * @var array
     */
    protected $typeMapping = [
        'int' => 'integer',
        'bool' => 'boolean',
        'double' => 'double',
        'float' => 'float',
        'string' => 'string'
    ];

    /**
     * @param string $dataProvider
     *
     * @return array
     * @throws \ReflectionException
     */
    public function convertToMapping(string $dataProvider): array
    {
        $reflector = new \ReflectionClass($dataProvider);
        $method = $reflector->getMethod('getElements');
        $method->setAccessible(true);

        $dataProvider = new $dataProvider();

        $configs = $method->invoke($dataProvider);

        $mapping = [];

        foreach ($configs as $field => $config) {
            $data = [];

            $data = $this->addType($data, $config);
            $data = $this->addProperties($data, $config);


            $mapping[$field] = $data;
        }

        return $mapping;
    }

    /**
     * @param array $data
     * @param array $config
     *
     * @return array
     * @throws \ReflectionException
     */
    protected function addProperties(array $data, array $config): array
    {
        if ($config['is_dataprovider']) {
            $data['properties'] = $this->convertToMapping(
                $config['type']
            );
        }

        return $data;
    }

    /**
     * @param array $data
     * @param array $config
     *
     * @return array
     */
    protected function addType(array $data, array $config): array
    {
        $originalType = $config['type'];

        if (array_key_exists($originalType, $this->typeMapping)) {
            $data['type'] = $this->typeMapping[$originalType];
        }

        if ($config['is_dataprovider']) {
            $data['type'] = 'object';
        }
        if ($config['is_collection']) {
            $data['type'] = 'nested';
        }

        return $data;
    }
}