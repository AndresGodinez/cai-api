<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 12:56 PM
 */

namespace Tests\DbModels\Entities;

use App\Core\AppContainer;
use DbModels\Entities\Clerk;
use DbModels\Entities\ChainStore;
use DbModels\Entities\Line;
use DbModels\Entities\State;
use DbModels\Entities\Store;
use DbModels\Entities\StoreClerk;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;

/**
 * Class StoreClerkEntityTest
 * @package Tests\DbModels\Entities
 */
class StoreClerkEntityTest extends DbUnitTestCase
{
    use ConfigurableConnectionTestTrait;

    /** @var ContainerInterface */
    private static $container;

    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();

        self::$container = AppContainer::make(BASE_DIR);
    }

    public function testRegSavedSuccessfully()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $register = new StoreClerk();
        $register->setStore($store);
        $register->setClerk($clerk);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s10_states', 1);
        $this->assertTableRowCount('s10_chain_stores', 1);
        $this->assertTableRowCount('s10_stores', 1);
        $this->assertTableRowCount('s10_clerks', 1);
        $this->assertTableRowCount('s20_stores_clerks', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s20_stores_clerks");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'store_id' => $store->getId(),
                'clerk_id' => $clerk->getId(),
            ],
            $testTable
        );
    }

    public function testErrorNullStore()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $register = new StoreClerk();
        $register->setClerk($clerk);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullClerk()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $register = new StoreClerk();
        $register->setStore($store);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNotUniqueStoreClerk()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $brand = new Clerk();
        $brand->setName('TEST');
        $brand->setCode('TEST');

        $register1 = new StoreClerk();
        $register1->setStore($store);
        $register1->setClerk($brand);

        $register2 = new StoreClerk();
        $register2->setStore($store);
        $register2->setClerk($brand);

        $em->persist($register1);
        $em->persist($register2);
        $em->flush();
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        $xmlFile = BASE_DIR . '/tests/dbunit-resources/default-empty.xml';
        return $this->createMySQLXMLDataSet($xmlFile);
    }
}