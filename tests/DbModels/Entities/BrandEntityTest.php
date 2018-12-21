<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:39 AM
 */

namespace Tests\DbModels\Entities;

use App\Core\AppContainer;
use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Entities\Brand;
use DbModels\Entities\Line;
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
 * Class BrandEntityTest
 * @package Tests\DbModels\Entities
 */
class BrandEntityTest extends DbUnitTestCase
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
        $this->assertClassHasAttribute('id', Brand::class);
        $this->assertClassHasAttribute('regCreatedDt', Brand::class);
        $this->assertClassHasAttribute('regUpdatedDt', Brand::class);
        $this->assertClassHasAttribute('regStatus', Brand::class);
    }

    public function testRegSavedSuccessfully()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $code = 'TEST';
        $now = new \DateTime();

        $line = new Line();
        $line->setName($name);
        $line->setCode($code);

        $register = new Brand();
        $register->setName($name);
        $register->setCode($code);
        $register->setLine($line);
        $register->setRegCreatedDt($now);
        $register->setRegUpdatedDt($now);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s10_lines', 1);
        $this->assertTableRowCount('s10_brands', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s10_brands");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'name' => $name,
                'code' => $code,
                'line_id' => $line->getId(),
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
        $code = 'TEST';

        $line = new Line();
        $line->setName($name);
        $line->setCode($code);

        $register = new Brand();
        $register->setName($name);
        $register->setCode($code);
        $register->setLine($line);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s10_lines', 1);
        $this->assertTableRowCount('s10_brands', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s10_brands");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'name' => $name,
                'code' => $code,
                'line_id' => $line->getId(),
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

        $code = 'TEST';

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $register = new Brand();
        $register->setCode($code);
        $register->setLine($line);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullCode()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $register = new Brand();
        $register->setName($name);
        $register->setLine($line);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullLine()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $code = 'TEST';

        $register = new Brand();
        $register->setName($name);
        $register->setCode($code);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNonUniqueCodeOnLine()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $code = 'TEST';

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $register1 = new Brand();
        $register1->setName($name);
        $register1->setCode($code);
        $register1->setLine($line);

        $register2 = new Brand();
        $register2->setName($name);
        $register2->setCode($code);
        $register2->setLine($line);

        $em->persist($register1);
        $em->persist($register2);
        $em->flush();
    }

    public function testSaveSuccessfullyDifferentBrandsOnSameLine()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $code1 = 'TEST1';
        $code2 = 'TEST2';

        $line = new Line();
        $line->setName('TEST');
        $line->setCode('TEST');

        $register1 = new Brand();
        $register1->setName($name);
        $register1->setCode($code1);
        $register1->setLine($line);

        $register2 = new Brand();
        $register2->setName($name);
        $register2->setCode($code2);
        $register2->setLine($line);

        $em->persist($register1);
        $em->persist($register2);
        $em->flush();

        $this->assertTableRowCount('s10_lines', 1);
        $this->assertTableRowCount('s10_brands', 2);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s10_brands");
        $this->assertTableContains(
            [
                'id' => $register1->getId(),
                'name' => $name,
                'code' => $code1,
                'line_id' => $line->getId(),
                'reg_created_dt' => null,
                'reg_updated_dt' => null,
                'reg_status' => DefaultEntityRegStatus::ACTIVE,
            ],
            $testTable
        );
        $this->assertTableContains(
            [
                'id' => $register2->getId(),
                'name' => $name,
                'code' => $code2,
                'line_id' => $line->getId(),
                'reg_created_dt' => null,
                'reg_updated_dt' => null,
                'reg_status' => DefaultEntityRegStatus::ACTIVE,
            ],
            $testTable
        );
    }

    public function testSaveSuccessfullyDifferentBrandsSameCodeOnDifferentLine()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $code = 'TEST1';

        $line1 = new Line();
        $line1->setName('TEST');
        $line1->setCode('TEST1');

        $line2 = new Line();
        $line2->setName('TEST');
        $line2->setCode('TEST2');

        $register1 = new Brand();
        $register1->setName($name);
        $register1->setCode($code);
        $register1->setLine($line1);

        $register2 = new Brand();
        $register2->setName($name);
        $register2->setCode($code);
        $register2->setLine($line2);

        $em->persist($register1);
        $em->persist($register2);
        $em->flush();

        $this->assertTableRowCount('s10_lines', 2);
        $this->assertTableRowCount('s10_brands', 2);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s10_brands");
        $this->assertTableContains(
            [
                'id' => $register1->getId(),
                'name' => $name,
                'code' => $code,
                'line_id' => $line1->getId(),
                'reg_created_dt' => null,
                'reg_updated_dt' => null,
                'reg_status' => DefaultEntityRegStatus::ACTIVE,
            ],
            $testTable
        );
        $this->assertTableContains(
            [
                'id' => $register2->getId(),
                'name' => $name,
                'code' => $code,
                'line_id' => $line2->getId(),
                'reg_created_dt' => null,
                'reg_updated_dt' => null,
                'reg_status' => DefaultEntityRegStatus::ACTIVE,
            ],
            $testTable
        );
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