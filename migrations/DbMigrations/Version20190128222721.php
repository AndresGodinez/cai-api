<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190128222721 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030531')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030532')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030533')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030534')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030535')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030536')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030537')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030538')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030539')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030540')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030541')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030542')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030543')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030544')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030545')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030546')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030547')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030548')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030549')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030550')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030551')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030552')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030553')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030554')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030555')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030556')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030557')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030558')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030559')");
        $this->addSql("INSERT INTO `s30_inventory_codes`(code) VALUES ('02030560')");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030531'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030532'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030533'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030534'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030535'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030536'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030537'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030538'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030539'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030540'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030541'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030542'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030543'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030544'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030545'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030546'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030547'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030548'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030549'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030550'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030551'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030552'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030553'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030554'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030555'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030556'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030557'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030558'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030559'");
        $this->addSql("DELETE a FROM `s30_inventory_codes` a WHERE code = '02030560'");
    }
}
