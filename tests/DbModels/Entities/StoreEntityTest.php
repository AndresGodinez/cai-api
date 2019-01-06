<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:51 AM
 */

namespace Tests\DbModels\Entities;

use App\Core\AppContainer;
use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Entities\ChainStore;
use DbModels\Entities\State;
use DbModels\Entities\Store;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\ORM\EntityManager;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;

/**
 * Class StoreEntityTest
 * @package Tests\DbModels\Entities
 */
class StoreEntityTest extends DbUnitTestCase
{
    use ConfigurableConnectionTestTrait;

    /** @var ContainerInterface */
    private static $container;

    public static function setUpBeforeClass()
    {
        TestUtils::initConsts();

        self::$container = AppContainer::make(BASE_DIR);
    }

    public function testEntityImplementsBaseFields()
    {
        $this->assertClassHasAttribute('id', Store::class);
        $this->assertClassHasAttribute('regCreatedDt', Store::class);
        $this->assertClassHasAttribute('regUpdatedDt', Store::class);
        $this->assertClassHasAttribute('regStatus', Store::class);
    }

    public function testRegSavedSuccessfully()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $cityName = 'TEST';
        $address = 'TEST';
        $postalCode = 'TEST';
        $schedule = 'TEST';
        $type = 'TEST';
        $now = new \DateTime();

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $register = new Store();
        $register->setName($name);
        $register->setCityName($cityName);
        $register->setAddress($address);
        $register->setPostalCode($postalCode);
        $register->setSchedule($schedule);
        $register->setType($type);
        $register->setState($state);
        $register->setChainStore($chainStore);
        $register->setRegCreatedDt($now);
        $register->setRegUpdatedDt($now);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s10_states', 1);
        $this->assertTableRowCount('s10_chain_stores', 1);
        $this->assertTableRowCount('s10_stores', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s10_stores");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'name' => $name,
                'city_name' => $cityName,
                'address' => $address,
                'postal_code' => $postalCode,
                'schedule' => $schedule,
                'type' => $type,
                'sap_code' => '',
                'state_id' => $state->getId(),
                'chain_store_id' => $chainStore->getId(),
                'reg_created_dt' => $now->format('Y-m-d H:i:s'),
                'reg_updated_dt' => $now->format('Y-m-d H:i:s'),
                'reg_status' => DefaultEntityRegStatus::ACTIVE,
            ],
            $testTable
        );
    }

    public function testRegSavedSuccessfullyWithNullableFields()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $register = new Store();
        $register->setName($name);
        $register->setState($state);
        $register->setChainStore($chainStore);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s10_states', 1);
        $this->assertTableRowCount('s10_chain_stores', 1);
        $this->assertTableRowCount('s10_stores', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s10_stores");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'name' => $name,
                'city_name' => '',
                'address' => '',
                'postal_code' => null,
                'schedule' => null,
                'type' => null,
                'sap_code' => '',
                'state_id' => $state->getId(),
                'chain_store_id' => $chainStore->getId(),
                'reg_created_dt' => null,
                'reg_updated_dt' => null,
                'reg_status' => DefaultEntityRegStatus::ACTIVE,
            ],
            $testTable
        );
    }

    public function testErrorNullName()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $register = new Store();
        $register->setState($state);
        $register->setChainStore($chainStore);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullState()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $register = new Store();
        $register->setName('TEST');
        $register->setChainStore($chainStore);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullChainStore()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $register = new Store();
        $register->setName('TEST');
        $register->setState($state);

        $em->persist($register);
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