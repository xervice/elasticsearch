<?php namespace XerviceTest\Elasticsearch\Integration;

use DataProvider\DocumentDataProvider;
use DataProvider\DocumentListDataProvider;
use DataProvider\ElasticSearchTestAddressDataProvider;
use DataProvider\ElasticSearchTestChildrenDataProvider;
use DataProvider\ElasticSearchTestDataProvider;
use Xervice\Config\Business\XerviceConfig;
use Xervice\Core\Business\Model\Locator\Dynamic\Business\DynamicBusinessLocator;
use Xervice\Core\Business\Model\Locator\Locator;
use Xervice\DataProvider\DataProviderConfig;
use Xervice\Elasticsearch\Business\Collection\IndexCollection;
use Xervice\Elasticsearch\Business\Model\Indexer;
use XerviceTest\Elasticsearch\Integration\Index\TestIndexProvider;
use XerviceTest\Elasticsearch\Integration\Index\TestIndexProviderWithTypes;

/**
 * @method \Xervice\Elasticsearch\Business\ElasticsearchFacade getFacade()
 * @method \Xervice\Elasticsearch\Business\ElasticsearchBusinessFactory getFactory()
 */
class IntegrationTest extends \Codeception\Test\Unit
{
    use DynamicBusinessLocator;

    /**
     * @var \XerviceTest\XerviceTester
     */
    protected $tester;

    protected function setUp()
    {
        parent::setUp();

        Locator::getInstance()->dataProvider()->facade()->generateDataProvider();

        XerviceConfig::getInstance()->getConfig()->set(
            DataProviderConfig::DATA_PROVIDER_PATHS,
            [
                __DIR__ . '/Dto'
            ]
        );

        XerviceConfig::set(DataProviderConfig::FILE_PATTERN, '*.testprovider.xml');

        Locator::getInstance()->dataProvider()->facade()->generateDataProvider();
    }

    protected function tearDown()
    {
        parent::tearDown();

//        Locator::getInstance()->dataProvider()->facade()->cleanDataProvider();
    }


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
        $this->createIndex(TestIndexProvider::class);

        $client = $this->getFactory()->getClient();
        $this->assertTrue(
            $client->getIndex('unittest')->exists()
        );

        $client->getIndex('unittest')->delete();
    }

    /**
     * @group Xervice
     * @group Elasticsearch
     * @group Integration
     * @group Indizes
     */
    public function testCreateExampleIndexWithType()
    {
        $this->createIndex(TestIndexProviderWithTypes::class);

        $client = $this->getFactory()->getClient();
        $this->assertTrue(
            $client->getIndex('unittest')->getType('testtype')->exists()
        );

        $this->assertEquals(
            'integer',
            $client->getIndex('unittest')->getType('testtype')->getMapping(
            )['testtype']['properties']['Address']['properties']['Zip']['type']
        );

        $client->getIndex('unittest')->delete();
    }

    /**
     * @group Xervice
     * @group Elasticsearch
     * @group Integration
     * @group Indizes
     */
    public function testCreateDocuments()
    {
        $this->createIndex(TestIndexProviderWithTypes::class);

        $address = (new ElasticSearchTestAddressDataProvider())
            ->setStreet('Teststreet')
            ->setNumber(5)
            ->setZip(123456);

        $child1 = (new ElasticSearchTestChildrenDataProvider())
            ->setName('Test Child')
            ->setAge(4);

        $child2 = (new ElasticSearchTestChildrenDataProvider())
            ->setName('Test Child 2')
            ->setAge(6);

        $dataProvider = (new ElasticSearchTestDataProvider())
            ->setName('Unit Test')
            ->setAge(32)
            ->setAddress($address)
            ->addChild($child1)
            ->addChild($child2);

        $documentList = (new DocumentListDataProvider())
            ->setIndex('testindex')
            ->setType('testtype')
            ->addDocument(
                (new DocumentDataProvider())
                    ->setIdent(1)
                    ->setContent($dataProvider->toArray())
            );

        $this->getFacade()->createDocuments(
            $documentList
        );

        $this->getFactory()->getClient()->getIndex('unittest')->delete();
    }

    /**
     * @param string $providerClass
     */
    protected function createIndex(string $providerClass): void
    {
        $collection = new IndexCollection(
            [
                new $providerClass()
            ]
        );

        $indexer = new Indexer(
            $collection,
            $this->getFactory()->createIndexBuilder(),
            $this->getFactory()->createMappingConverter()
        );

        $indexer->createIndizes();


    }
}