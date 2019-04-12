<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch;


use Elastica\Client;
use Xervice\Core\Business\Model\Dependency\Provider\AbstractDependencyProvider;
use Xervice\Core\Business\Model\Dependency\DependencyContainerInterface;
use Xervice\Elasticsearch\Business\Collection\IndexCollection;

/**
 * @method \Xervice\Core\Locator\Locator getLocator()
 * @method \Xervice\Elasticsearch\ElasticsearchConfig getConfig()
 */
class ElasticsearchDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT = 'elasticsearch.client';

    public const INDEX_PROVIDER = 'elasticsearch.index.provider';

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    public function handleDependencies(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container = $this->setClient($container);
        $container = $this->setIndexProvider($container);

        return $container;
    }

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    protected function setClient(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[self::CLIENT] = function (DependencyContainerInterface $container) {
            return $this->getClient();
        };

        return $container;
    }

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    protected function setIndexProvider(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[self::INDEX_PROVIDER] = function (DependencyContainerInterface $container) {
            return new IndexCollection(
                $this->getIndexProvider()
            );
        };

        return $container;
    }

    /**
     * @return \Elastica\Client
     */
    protected function getClient()
    {
        return new Client(
            [
                'host' => $this->getConfig()->getHost(),
                'port' => $this->getConfig()->getPort()
            ]
        );
    }

    /**
     * @return \Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface[]
     */
    protected function getIndexProvider(): array
    {
        return [];
    }
}
