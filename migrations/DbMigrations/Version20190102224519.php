<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190102224519 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s30_inventory_codes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `inventory_codes_uidx_code` (`code` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE IF EXISTS s30_inventory_codes");
    }
}
