<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190125040052 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("UPDATE `s00_users` SET name = 'Kevin Gomez Belmont', username = 'k.gomez', pswd = '$2y$10$7xSNEbhPimI4MlgvhCrRZeC4jSMLWeY8w/JKeqript4AkcWxlGnu2' WHERE id = 16");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Kevin Gomez Belmont' WHERE id = 15");

        $this->addSql("UPDATE `s00_users` SET name = 'Juan Carlos Pérez Escobar', username = 'j.perez2', pswd = '$2y$10$.CpvtMyw4IKmYtWRbjeCuen0IedSkS.cYccYtjnX035lJqZTSB6wK' WHERE id = 18");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Juan Carlos Pérez Escobar' WHERE id = 17");

        $this->addSql("UPDATE `s00_users` SET name = 'Fernando Oziel Mata Cruz', username = 'f.mata', pswd = '$2y$10\$EvJsT1OQOaMS8Xatyu//2O/DoYoh5AhPdBp1gEDUBtyhGgkFl/8IS' WHERE id = 21");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Fernando Oziel Mata Cruz' WHERE id = 20");

        $this->addSql("UPDATE `s00_users` SET name = 'Irepan Quintero Ulises' WHERE id = 24");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Irepan Quintero Ulises' WHERE id = 23");

        $this->addSql("UPDATE `s00_users` SET name = 'Abel Alejandro Esparza Venegas', username = 'a.esparza2', pswd = '$2y$10$5qQ.0wcq8iv3BdSR8hvpx.3JrUwz9A2N3d0mZQtUmcRI5xTzaNpUi' WHERE id = 30");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Abel Alejandro Esparza Venegas' WHERE id = 29");

        $this->addSql("UPDATE `s00_users` SET name = 'Gabriela Morato Alvarez', username = 'g.morato2', pswd = '$2y$10\$Sq05tJIr50dzc7fXesWo.OcqqJYeqVOadxq3TlhQurk5sA1UIT4Na' WHERE id = 33");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Gabriela Morato Alvarez' WHERE id = 32");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("UPDATE `s00_users` SET name = 'PEND', username = '', pswd = '' WHERE id = 16");
        $this->addSql("UPDATE `s10_clerks` SET name = 'PEND' WHERE id = 15");

        $this->addSql("UPDATE `s00_users` SET name = 'Pedro de Jesús Quijano Ramírez', username = 'p.quijano', pswd = '$2y$10\$j7E/LKbmVKsGesZjrUjSDOIOzyiY6U.iB8vpUwAbqdyOc4voFa/76' WHERE id = 18");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Pedro de Jesús Quijano Ramírez' WHERE id = 17");

        $this->addSql("UPDATE `s00_users` SET name = 'Miguel Eliut Bañuelos Silva', username = 'm.banuelos', pswd = '$2y$10$9B1lzjlam4P4S975qVz.B.QJreAvO2KeDOyJ9b.WsbFGlfLE9hEty' WHERE id = 21");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Miguel Eliut Bañuelos Silva' WHERE id = 20");

        $this->addSql("UPDATE `s00_users` SET name = 'Ulises Irepan Quintero' WHERE id = 24");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Ulises Irepan Quintero' WHERE id = 23");

        $this->addSql("UPDATE `s00_users` SET name = 'PEND', username = '', pswd = '' WHERE id = 30");
        $this->addSql("UPDATE `s10_clerks` SET name = 'PEND' WHERE id = 29");

        $this->addSql("UPDATE `s00_users` SET name = 'Manuel Ivan Montalvo Maldonado', username = 'm.montalvo', pswd = '$2y$10\$tfKMsHRwpjp3MRncSn2mpOV1Q36CHIJ8xPbQHxIAbi7QLaTo3029W' WHERE id = 33");
        $this->addSql("UPDATE `s10_clerks` SET name = 'Manuel Ivan Montalvo Maldonado' WHERE id = 32");
    }
}
