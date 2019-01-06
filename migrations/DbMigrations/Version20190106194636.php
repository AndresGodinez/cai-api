<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190106194636 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(
        /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s20_brands_furniture_types` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `brand_id` BIGINT NOT NULL,
  `furniture_type_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `bft_idx_brand_id` (`brand_id` ASC),
  INDEX `bft_idx_furniture_type_id` (`furniture_type_id` ASC),
  UNIQUE INDEX `bft_uidx_brand_id_furniture_type_id` (`brand_id` ASC, `furniture_type_id` ASC))
ENGINE = InnoDB
CREATE_TABLE
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE IF EXISTS s20_brands_furniture_types");
    }
}
