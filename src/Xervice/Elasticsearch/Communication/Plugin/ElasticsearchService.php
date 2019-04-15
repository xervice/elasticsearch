<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Communication\Plugin;


use Xervice\Core\Plugin\AbstractBusinessPlugin;
use Xervice\Kernel\Business\Model\Service\ServiceProviderInterface;
use Xervice\Kernel\Business\Plugin\BootInterface;

/**
 * @method \Xervice\Elasticsearch\Business\ElasticsearchFacadeInterface getFacade()
 */
class ElasticsearchService extends AbstractBusinessPlugin implements BootInterface
{
    /**
     * @param \Xervice\Kernel\Business\Model\Service\ServiceProviderInterface $serviceProvider
     */
    public function boot(ServiceProviderInterface $serviceProvider): void
    {
        $this
            ->getFacade()
            ->createIndizes();
    }
}