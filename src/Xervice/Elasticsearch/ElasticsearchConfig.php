<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch;


use Xervice\Core\Business\Model\Config\AbstractConfig;

class ElasticsearchConfig extends AbstractConfig
{
    public const HOST = 'elasticsearch.host';
    public const PORT = 'elasticsearch.port';

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->get(self::HOST, '127.0.0.1');
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->get(self::PORT, 9200);
    }
}