<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 01:13 PM
 */

namespace Tests\DbModels\Entities;

use App\Core\AppContainer;
use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Consts\InventoryEvidencePhotoType;
use DbModels\Entities\Brand;
use DbModels\Entities\ChainStore;
use DbModels\Entities\Clerk;
use DbModels\Entities\FurnitureType;
use DbModels\Entities\InventoryEvidence;
use DbModels\Entities\InventoryEvidencePhoto;
use DbModels\Entities\Line;
use DbModels\Entities\State;
use DbModels\Entities\Store;
use DbModels\Entities\User;
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
 * Class InventoryEvidenceEntityTest
 * @package Tests\DbModels\Entities
 */
class InventoryEvidenceEntityTest extends DbUnitTestCase
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
        $this->assertClassHasAttribute('id', InventoryEvidence::class);
        $this->assertClassHasAttribute('regCreatedDt', InventoryEvidence::class);
        $this->assertClassHasAttribute('regUpdatedDt', InventoryEvidence::class);
        $this->assertClassHasAttribute('regStatus', InventoryEvidence::class);
    }

    public function testRegSavedSuccessfully()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $code = 'TEST';
        $now = new \DateTime();

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $user = new User();
        $user->setName('TEST');
        $user->setUsername('TEST');
        $user->setClerk($clerk);

        $register = new InventoryEvidence();
        $register->setCode($code);
        $register->setStore($store);
        $register->setBrand($brand);
        $register->setClerk($clerk);
        $register->setFurnitureType($furnitureType);
        $register->setUser($user);
        $register->setRegCreatedDt($now);
        $register->setRegUpdatedDt($now);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s00_users', 1);
        $this->assertTableRowCount('s10_clerks', 1);
        $this->assertTableRowCount('s10_states', 1);
        $this->assertTableRowCount('s10_chain_stores', 1);
        $this->assertTableRowCount('s10_stores', 1);
        $this->assertTableRowCount('s10_lines', 1);
        $this->assertTableRowCount('s10_brands', 1);
        $this->assertTableRowCount('s10_furniture_types', 1);
        $this->assertTableRowCount('s30_inventory_evidences', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s30_inventory_evidences");
        $this->assertTableContains(
            [
                'id' => $user->getId(),
                'code' => $code,
                'store_id' => $store->getId(),
                'brand_id' => $brand->getId(),
                'furniture_type_id' => $furnitureType->getId(),
                'clerk_id' => $clerk->getId(),
                'user_id' => $user->getId(),
                'reg_created_dt' => $now->format('Y-m-d H:i:s'),
                'reg_updated_dt' => $now->format('Y-m-d H:i:s'),
                'reg_status' => DefaultEntityRegStatus::ACTIVE,
            ],
            $testTable
        );
    }

    public function testRegSavedSuccessfullyWithPhoto()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $code = 'TEST';
        $now = new \DateTime();

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $user = new User();
        $user->setName('TEST');
        $user->setUsername('TEST');
        $user->setClerk($clerk);

        $photo = new InventoryEvidencePhoto();
        $photo->setFilePath('TEST');
        $photo->setType(InventoryEvidencePhotoType::FURNITURE);

        $register = new InventoryEvidence();
        $register->setCode($code);
        $register->setStore($store);
        $register->setBrand($brand);
        $register->setClerk($clerk);
        $register->setFurnitureType($furnitureType);
        $register->setUser($user);
        $register->setRegCreatedDt($now);
        $register->setRegUpdatedDt($now);

        $register->addPhoto($photo);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s00_users', 1);
        $this->assertTableRowCount('s10_clerks', 1);
        $this->assertTableRowCount('s10_states', 1);
        $this->assertTableRowCount('s10_chain_stores', 1);
        $this->assertTableRowCount('s10_stores', 1);
        $this->assertTableRowCount('s10_lines', 1);
        $this->assertTableRowCount('s10_brands', 1);
        $this->assertTableRowCount('s10_furniture_types', 1);
        $this->assertTableRowCount('s30_inventory_evidences', 1);
        $this->assertTableRowCount('s30_inventory_evidence_photos', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s30_inventory_evidences");
        $this->assertTableContains(
            [
                'id' => $user->getId(),
                'code' => $code,
                'store_id' => $store->getId(),
                'brand_id' => $brand->getId(),
                'furniture_type_id' => $furnitureType->getId(),
                'clerk_id' => $clerk->getId(),
                'user_id' => $user->getId(),
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

        $code = 'TEST';

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $user = new User();
        $user->setName('TEST');
        $user->setUsername('TEST');
        $user->setClerk($clerk);

        $register = new InventoryEvidence();
        $register->setCode($code);
        $register->setStore($store);
        $register->setBrand($brand);
        $register->setClerk($clerk);
        $register->setFurnitureType($furnitureType);
        $register->setUser($user);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s00_users', 1);
        $this->assertTableRowCount('s10_clerks', 1);
        $this->assertTableRowCount('s10_states', 1);
        $this->assertTableRowCount('s10_chain_stores', 1);
        $this->assertTableRowCount('s10_stores', 1);
        $this->assertTableRowCount('s10_lines', 1);
        $this->assertTableRowCount('s10_brands', 1);
        $this->assertTableRowCount('s10_furniture_types', 1);
        $this->assertTableRowCount('s30_inventory_evidences', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s30_inventory_evidences");
        $this->assertTableContains(
            [
                'id' => $user->getId(),
                'code' => $code,
                'store_id' => $store->getId(),
                'brand_id' => $brand->getId(),
                'furniture_type_id' => $furnitureType->getId(),
                'clerk_id' => $clerk->getId(),
                'user_id' => $user->getId(),
                'reg_created_dt' => null,
                'reg_updated_dt' => null,
                'reg_status' => DefaultEntityRegStatus::ACTIVE,
            ],
            $testTable
        );
    }

    public function testErrorNullCode()
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

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $user = new User();
        $user->setName('TEST');
        $user->setUsername('TEST');
        $user->setClerk($clerk);

        $register = new InventoryEvidence();
        $register->setStore($store);
        $register->setBrand($brand);
        $register->setClerk($clerk);
        $register->setFurnitureType($furnitureType);
        $register->setUser($user);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullStore()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $code = 'TEST';

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $user = new User();
        $user->setName('TEST');
        $user->setUsername('TEST');
        $user->setClerk($clerk);

        $register = new InventoryEvidence();
        $register->setCode($code);
        $register->setBrand($brand);
        $register->setClerk($clerk);
        $register->setFurnitureType($furnitureType);
        $register->setUser($user);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullBrand()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $code = 'TEST';

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $user = new User();
        $user->setName('TEST');
        $user->setUsername('TEST');
        $user->setClerk($clerk);

        $register = new InventoryEvidence();
        $register->setCode($code);
        $register->setStore($store);
        $register->setClerk($clerk);
        $register->setFurnitureType($furnitureType);
        $register->setUser($user);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullFurnitureType()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $code = 'TEST';

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $user = new User();
        $user->setName('TEST');
        $user->setUsername('TEST');
        $user->setClerk($clerk);

        $register = new InventoryEvidence();
        $register->setCode($code);
        $register->setStore($store);
        $register->setBrand($brand);
        $register->setClerk($clerk);
        $register->setUser($user);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullClerk()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $code = 'TEST';

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $user = new User();
        $user->setName('TEST');
        $user->setUsername('TEST');
        $user->setClerk($clerk);

        $register = new InventoryEvidence();
        $register->setCode($code);
        $register->setStore($store);
        $register->setBrand($brand);
        $register->setFurnitureType($furnitureType);
        $register->setUser($user);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullUser()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $code = 'TEST';

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $register = new InventoryEvidence();
        $register->setCode($code);
        $register->setStore($store);
        $register->setBrand($brand);
        $register->setClerk($clerk);
        $register->setFurnitureType($furnitureType);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNonUniqueCode()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $code = 'TEST';

        $state = new State();
        $state->setName('TEST');
        $state->setCode('TEST');

        $chainStore = new ChainStore();
        $chainStore->setName('TEST');

        $store = new Store();
        $store->setName('TEST');
        $store->setState($state);
        $store->setChainStore($chainStore);

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $user = new User();
        $user->setName('TEST');
        $user->setUsername('TEST');
        $user->setClerk($clerk);

        $register1 = new InventoryEvidence();
        $register1->setCode($code);
        $register1->setStore($store);
        $register1->setBrand($brand);
        $register1->setClerk($clerk);
        $register1->setFurnitureType($furnitureType);
        $register1->setUser($user);

        $register2 = new InventoryEvidence();
        $register2->setCode($code);
        $register2->setStore($store);
        $register2->setBrand($brand);
        $register2->setClerk($clerk);
        $register2->setFurnitureType($furnitureType);
        $register2->setUser($user);

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