<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181220014633 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s00_users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `pswd` TEXT NULL,
  `type` TINYINT(4) NOT NULL DEFAULT 0 COMMENT '0 => UNKNOWN\n1 => ADMIN\n2 => CLERK',
  `clerk_id` BIGINT NULL,
  `reg_created_dt` DATETIME NULL,
  `reg_updated_dt` DATETIME NULL,
  `reg_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '0 => INACTIVE\n1 => ACTIVE',
  PRIMARY KEY (`id`),
  INDEX `users_idx_clerk_id` (`clerk_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s10_clerks` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(100) NOT NULL,
  `reg_created_dt` DATETIME NULL,
  `reg_updated_dt` DATETIME NULL,
  `reg_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '0 => INACTIVE\n1 => ACTIVE',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `clerks_uidx_code` (`code` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s10_furniture_types` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `brand_id` BIGINT NULL,
  `reg_created_dt` DATETIME NULL,
  `reg_updated_dt` DATETIME NULL,
  `reg_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '0 => INACTIVE\n1 => ACTIVE',
  PRIMARY KEY (`id`),
  INDEX `furniture_types_idx_brand_id` (`brand_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s10_states` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(100) NOT NULL,
  `reg_created_dt` DATETIME NULL,
  `reg_updated_dt` DATETIME NULL,
  `reg_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '0 => INACTIVE\n1 => ACTIVE',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `states_uidx_code` (`code` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s10_lines` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(100) NOT NULL,
  `reg_created_dt` DATETIME NULL,
  `reg_updated_dt` DATETIME NULL,
  `reg_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '0 => INACTIVE\n1 => ACTIVE',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `lines_uidx_code` (`code` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s10_brands` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(100) NOT NULL,
  `line_id` BIGINT NOT NULL,
  `reg_created_dt` DATETIME NULL,
  `reg_updated_dt` DATETIME NULL,
  `reg_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '0 => INACTIVE\n1 => ACTIVE',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `brands_uidx_code_line_id` (`line_id` ASC, `code` ASC),
  INDEX `brands_idx_line_id` (`line_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s10_chain_stores` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `reg_created_dt` DATETIME NULL,
  `reg_updated_dt` DATETIME NULL,
  `reg_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '0 => INACTIVE\n1 => ACTIVE',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s10_stores` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `city_name` VARCHAR(255) NOT NULL DEFAULT '',
  `address` TEXT NOT NULL,
  `postal_code` VARCHAR(30) NULL,
  `schedule` VARCHAR(50) NULL,
  `type` VARCHAR(50) NULL,
  `sap_code` VARCHAR(50) NOT NULL DEFAULT '',
  `state_id` BIGINT NOT NULL,
  `chain_store_id` BIGINT NOT NULL,
  `reg_created_dt` DATETIME NULL,
  `reg_updated_dt` DATETIME NULL,
  `reg_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '0 => INACTIVE\n1 => ACTIVE',
  PRIMARY KEY (`id`),
  INDEX `stores_idx_type` (`type` ASC),
  INDEX `stores_idx_state_id` (`state_id` ASC),
  INDEX `stores_idx_chain_store_id` (`chain_store_id` ASC),
  INDEX `stores_idx_city_name` (`city_name` ASC),
  INDEX `stores_idx_sap_code` (`sap_code` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s20_stores_clerks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_id` BIGINT NOT NULL,
  `clerk_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `sc_uidx_store_id_clerk_id` (`store_id` ASC, `clerk_id` ASC))
ENGINE = InnoDB
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s20_stores_brands` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_id` BIGINT NOT NULL,
  `brand_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `sb_uidx_store_id_brand_id` (`store_id` ASC, `brand_id` ASC))
ENGINE = InnoDB
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s30_inventory_evidences` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(255) NOT NULL,
  `store_id` BIGINT NOT NULL,
  `brand_id` BIGINT NOT NULL,
  `furniture_type_id` BIGINT NOT NULL,
  `clerk_id` BIGINT NOT NULL,
  `user_id` BIGINT NOT NULL,
  `reg_created_dt` DATETIME NULL,
  `reg_updated_dt` DATETIME NULL,
  `reg_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '0 => INACTIVE\n1 => ACTIVE',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `ie_uidx_code` (`code` ASC),
  INDEX `ie_idx_store_id` (`store_id` ASC),
  INDEX `ie_idx_brand_id` (`brand_id` ASC),
  INDEX `ie_idx_furniture_type_id` (`furniture_type_id` ASC),
  INDEX `ie_idx_clerk_id` (`clerk_id` ASC),
  INDEX `ie_idx_user_id` (`user_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );

        $this->addSql(
            /** @lang SQL */
            <<<CREATE_TABLE
CREATE TABLE IF NOT EXISTS `s30_inventory_evidence_photos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_path` TEXT NULL,
  `type` TINYINT(4) NOT NULL COMMENT '0 => UNKNOWN\n1 => FURNITURE\n2 => QR',
  `inventory_evidence_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `iep_idx_inventory_evidence_id` (`inventory_evidence_id` ASC),
  UNIQUE INDEX `iep_uidx_inventory_evidence_type` (`inventory_evidence_id` ASC, `type` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
CREATE_TABLE
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE IF EXISTS s00_users");
        $this->addSql("DROP TABLE IF EXISTS s10_clerks");
        $this->addSql("DROP TABLE IF EXISTS s10_furniture_types");
        $this->addSql("DROP TABLE IF EXISTS s10_states");
        $this->addSql("DROP TABLE IF EXISTS s10_lines");
        $this->addSql("DROP TABLE IF EXISTS s10_brands");
        $this->addSql("DROP TABLE IF EXISTS s10_chain_stores");
        $this->addSql("DROP TABLE IF EXISTS s10_stores");
        $this->addSql("DROP TABLE IF EXISTS s20_stores_clerks");
        $this->addSql("DROP TABLE IF EXISTS s20_stores_brands");
        $this->addSql("DROP TABLE IF EXISTS s30_inventory_evidences");
        $this->addSql("DROP TABLE IF EXISTS s30_inventory_evidence_photos");
    }
}
