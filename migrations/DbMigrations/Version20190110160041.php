<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190110160041 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Eduardo Rivera Arana' WHERE t.`id` = 1");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Diana Laura Chávez Martínez' WHERE t.`id` = 5");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'David Camilo Alejandro' WHERE t.`id` = 9");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Daniela Ruíz Urbina' WHERE t.`id` = 16");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Pedro de Jesús Quijano Ramírez' WHERE t.`id` = 17");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Marcial Maciel Bobadilla' WHERE t.`id` = 19");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Miguel Eliut Bañuelos Silva' WHERE t.`id` = 20");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Jorge Enrique Padilla Romero' WHERE t.`id` = 24");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'César Cassio Meléndez' WHERE t.`id` = 27");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Carlos Eduardo De la Vega Sánchez' WHERE t.`id` = 28");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Jesús Eduardo del Real Villa' WHERE t.`id` = 33");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 1");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 5");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 9");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Leopoldo Agustín Alvarez Guillen' WHERE t.`id` = 16");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 17");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Armando Duarte Ramirez' WHERE t.`id` = 19");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 20");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 24");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 27");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 28");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Jesús Eduardo del Villar' WHERE t.`id` = 33");
    }
}
