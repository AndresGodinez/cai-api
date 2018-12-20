<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 01:27 PM
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
 * Class InventoryEvidencePhotoEntityTest
 * @package Tests\DbModels\Entities
 */
class InventoryEvidencePhotoEntityTest extends DbUnitTestCase
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

        $filePath = 'TEST';

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

        $inventoryEvidence = new InventoryEvidence();
        $inventoryEvidence->setCode('TEST');
        $inventoryEvidence->setStore($store);
        $inventoryEvidence->setBrand($brand);
        $inventoryEvidence->setClerk($clerk);
        $inventoryEvidence->setFurnitureType($furnitureType);
        $inventoryEvidence->setUser($user);

        $register1 = new InventoryEvidencePhoto();
        $register1->setFilePath($filePath);
        $register1->setType(InventoryEvidencePhotoType::FURNITURE);

        $register2 = new InventoryEvidencePhoto();
        $register2->setFilePath($filePath);
        $register2->setType(InventoryEvidencePhotoType::QR);

        $inventoryEvidence->addPhoto($register1);
        $inventoryEvidence->addPhoto($register2);

        $em->persist($inventoryEvidence);
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
        $this->assertTableRowCount('s30_inventory_evidence_photos', 2);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s30_inventory_evidence_photos");
        $this->assertTableContains(
            [
                'id' => $register1->getId(),
                'file_path' => $filePath,
                'type' => InventoryEvidencePhotoType::FURNITURE,
                'inventory_evidence_id' => $inventoryEvidence->getId(),
            ],
            $testTable
        );
        $this->assertTableContains(
            [
                'id' => $register2->getId(),
                'file_path' => $filePath,
                'type' => InventoryEvidencePhotoType::QR,
                'inventory_evidence_id' => $inventoryEvidence->getId(),
            ],
            $testTable
        );
    }

    public function testErrorNullInventoryEvidence()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $register = new InventoryEvidencePhoto();
        $register->setFilePath('TEST');
        $register->setType(InventoryEvidencePhotoType::QR);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorRepeatedInventoryEvidenceType()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $filePath = 'TEST';

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

        $inventoryEvidence = new InventoryEvidence();
        $inventoryEvidence->setCode('TEST');
        $inventoryEvidence->setStore($store);
        $inventoryEvidence->setBrand($brand);
        $inventoryEvidence->setClerk($clerk);
        $inventoryEvidence->setFurnitureType($furnitureType);
        $inventoryEvidence->setUser($user);

        $register1 = new InventoryEvidencePhoto();
        $register1->setFilePath($filePath);
        $register1->setType(InventoryEvidencePhotoType::FURNITURE);

        $register2 = new InventoryEvidencePhoto();
        $register2->setFilePath($filePath);
        $register2->setType(InventoryEvidencePhotoType::FURNITURE);

        $inventoryEvidence->addPhoto($register1);
        $inventoryEvidence->addPhoto($register2);

        $em->persist($inventoryEvidence);
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