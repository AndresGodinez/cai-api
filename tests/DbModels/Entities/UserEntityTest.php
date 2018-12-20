<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:11 AM
 */

namespace Tests\DbModels\Entities;

use App\Core\AppContainer;
use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Consts\UserType;
use DbModels\Entities\Clerk;
use DbModels\Entities\User;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\ORM\EntityManager;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Psr\Container\ContainerInterface;
use Tests\ConfigurableConnectionTestTrait;
use Tests\DbUnitTestCase;
use Tests\TestUtils;

/**
 * Class UserEntityTest
 * @package Tests\DbModels\Entities
 */
class UserEntityTest extends DbUnitTestCase
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
        $this->assertClassHasAttribute('id', User::class);
        $this->assertClassHasAttribute('regCreatedDt', User::class);
        $this->assertClassHasAttribute('regUpdatedDt', User::class);
        $this->assertClassHasAttribute('regStatus', User::class);
    }

    public function testRegSavedSuccessfully()
    {
        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $username = 'TEST';
        $pswd = 'TEST';
        $type = UserType::ADMIN;
        $now = new \DateTime();

        $clerk = new Clerk();
        $clerk->setName('TEST');
        $clerk->setCode('TEST');

        $register = new User();
        $register->setName($name);
        $register->setUsername($username);
        $register->setPswd($pswd);
        $register->setType($type);
        $register->setClerk($clerk);
        $register->setRegCreatedDt($now);
        $register->setRegUpdatedDt($now);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s00_users', 1);
        $this->assertTableRowCount('s10_clerks', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s00_users");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'name' => $name,
                'username' => $username,
                'pswd' => $pswd,
                'type' => $type,
                'clerk_id' => $clerk->getId(),
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
        $username = 'TEST';
        $type = UserType::ADMIN;

        $register = new User();
        $register->setName($name);
        $register->setUsername($username);
        $register->setType($type);

        $em->persist($register);
        $em->flush();

        $this->assertTableRowCount('s00_users', 1);

        /** @var Connection $conn */
        $conn = $this->getConnection();

        $testTable = $conn->createQueryTable('test_table', "SELECT * FROM s00_users");
        $this->assertTableContains(
            [
                'id' => $register->getId(),
                'name' => $name,
                'username' => $username,
                'pswd' => null,
                'type' => $type,
                'clerk_id' => null,
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

        $username = 'TEST';
        $type = UserType::ADMIN;

        $register = new User();
        $register->setUsername($username);
        $register->setType($type);

        $em->persist($register);
        $em->flush();
    }

    public function testErrorNullUsername()
    {
        $this->expectException(NotNullConstraintViolationException::class);

        /** @var EntityManager $em */
        $em = self::$container->get('test-entity-manager');

        $name = 'TEST';
        $type = UserType::ADMIN;

        $register = new User();
        $register->setName($name);
        $register->setType($type);

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