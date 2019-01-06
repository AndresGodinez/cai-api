<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 6/01/19
 * Time: 01:52 PM
 */

namespace Tests\DbModels\Entities;

use App\Core\AppContainer;
use DbModels\Entities\Brand;
use DbModels\Entities\BrandFurnitureType;
use DbModels\Entities\ChainStore;
use DbModels\Entities\FurnitureType;
use DbModels\Entities\Line;
use DbModels\Entities\State;
use DbModels\Entities\Store;
use DbModels\Entities\StoreBrand;
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
 * Class BrandFurnitureTypeEntityTest
 * @package Tests\DbModels\Entities
 */
class BrandFurnitureTypeEntityTest extends DbUnitTestCase
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

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');
        $furnitureType->setDescription('TEST');

        $register = new BrandFurnitureType();
        $register->setBrand($brand);
        $register->setFurnitureType($furnitureType);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s10_lines', 1);
        $this->assertTableRowCount('s10_brands', 1);
        $this->assertTableRowCount('s10_furniture_types', 1);
        $this->assertTableRowCount('s20_brands_furniture_types', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s20_brands_furniture_types");
        $this->assertTableContains(
            [
                'id' => $furnitureType->getId(),
                'brand_id' => $brand->getId(),
                'furniture_type_id' => $furnitureType->getId(),
            ],
            $testTable
        );
    }

    public function testErrorNullBrand()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');
        $furnitureType->setDescription('TEST');

        $register = new BrandFurnitureType();
        $register->setFurnitureType($furnitureType);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullFurnitureType()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $register = new BrandFurnitureType();
        $register->setBrand($brand);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNotUniqueStoreBrand()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $brand = new Brand();
        $brand->setName('TEST');
        $brand->setCode('TEST');
        $brand->setLine($line);

        $furnitureType = new FurnitureType();
        $furnitureType->setName('TEST');
        $furnitureType->setDescription('TEST');

        $register1 = new BrandFurnitureType();
        $register1->setBrand($brand);
        $register1->setFurnitureType($furnitureType);

        $register2 = new BrandFurnitureType();
        $register2->setBrand($brand);
        $register2->setFurnitureType($furnitureType);

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