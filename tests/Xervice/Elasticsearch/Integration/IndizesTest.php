<?php namespace XerviceTest\Elasticsearch\Integration;

use Xervice\Core\Business\Model\Locator\Dynamic\Business\DynamicBusinessLocator;
use Xervice\Elasticsearch\Business\Collection\IndexCollection;
use Xervice\Elasticsearch\Business\Model\Indexer;
use XerviceTest\Elasticsearch\Integration\Index\TestIndexProvider;

/**
 * @method \Xervice\Elasticsearch\Business\ElasticsearchFacade getFacade()
 * @method \Xervice\Elasticsearch\Business\ElasticsearchBusinessFactory getFactory()
 */
class IndizesTest extends \Codeception\Test\Unit
{
    use DynamicBusinessLocator;

    /**
     * @var \XerviceTest\XerviceTester
     */
    protected $tester;

    /**
     * @group Xervice
     * @group Elasticsearch
     * @group Integration
     * @group Indizes
     */
    public function testCreateIndizesWithoutPlugins()
    {
        $this->getFacade()->createIndizes();
    }

    /**
     * @group Xervice
     * @group Elasticsearch
     * @group Integration
     * @group Indizes
     */
    public function testCreateExampleIndex()
    {
        $collection = new IndexCollection(
            [
                new TestIndexProvider()
            ]
        );

        $indexer = new Indexer(
            $collection,
            $this->getFactory()->createIndexBuilder()
        );

        $indexer->createIndizes();

        $client = $this->getFactory()->getClient();
        $this->assertTrue(
            $client->getIndex('unittest')->exists()
        );

        $client->getIndex('unittest')->delete();
    }
}