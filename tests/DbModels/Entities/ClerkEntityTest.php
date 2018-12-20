<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:54 AM
 */

namespace Tests\DbModels\Entities;

use App\Core\AppContainer;
use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Entities\Clerk;
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
 * Class ClerkEntityTest
 * @package Tests\DbModels\Entities
 */
class ClerkEntityTest extends DbUnitTestCase
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
        $this->assertClassHasAttribute('id', Clerk::class);
        $this->assertClassHasAttribute('regCreatedDt', Clerk::class);
        $this->assertClassHasAttribute('regUpdatedDt', Clerk::class);
        $this->assertClassHasAttribute('regStatus', Clerk::class);
    }

    public function testRegSavedSuccessfully()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $code = 'TEST';
        $now = new \DateTime();

        $register = new Clerk();
        $register->setName($name);
        $register->setCode($code);
        $register->setRegCreatedDt($now);
        $register->setRegUpdatedDt($now);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s10_clerks', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s10_clerks");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'name' => $name,
                'code' => $code,
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

        $register = new Clerk();
        $register->setName($name);
        $register->setCode($code);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s10_clerks', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s10_clerks");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'name' => $name,
                'code' => $code,
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

        $register = new Clerk();
        $register->setCode($code);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullCode()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';

        $register = new Clerk();
        $register->setName($name);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNonUniqueCode()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $code = 'TEST';

        $register1 = new Clerk();
        $register1->setName($name);
        $register1->setCode($code);

        $register2 = new Clerk();
        $register2->setName($name);
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