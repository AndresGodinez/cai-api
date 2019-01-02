<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 2/01/19
 * Time: 05:11 PM
 */

namespace Tests\DbModels\Entities;

use App\Core\AppContainer;
use DbModels\Entities\InventoryCode;
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
 * Class InventoryCodeEntityTest
 * @package Tests\DbModels\Entities
 */
class InventoryCodeEntityTest extends DbUnitTestCase
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

        $code = 'TEST';

        $register = new InventoryCode();
        $register->setCode($code);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s30_inventory_codes', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s30_inventory_codes");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'code' => $code,
            ],
            $testTable
        );
    }

    public function testErrorNullCode()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $register = new InventoryCode();

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNonUniqueCode()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $code = 'TEST';

        $register1 = new InventoryCode();
        $register1->setCode($code);

        $register2 = new InventoryCode();
        $register2->setCode($code);

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