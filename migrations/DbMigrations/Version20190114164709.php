<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190114164709 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO s10_furniture_types (id, name, description, reg_created_dt, reg_updated_dt, reg_status) VALUES (135, 'GONDOLAS BASICA', null, null, null, 1)");
        $this->addSql("INSERT INTO s10_furniture_types (id, name, description, reg_created_dt, reg_updated_dt, reg_status) VALUES (136, 'GONDOLAS PREMIUM', null, null, null, 1)");
        $this->addSql("INSERT INTO s10_furniture_types (id, name, description, reg_created_dt, reg_updated_dt, reg_status) VALUES (137, 'RACK FACE 5 NIVELES', null, null, null, 1)");
        $this->addSql("INSERT INTO s10_furniture_types (id, name, description, reg_created_dt, reg_updated_dt, reg_status) VALUES (138, 'COLUMNA', null, null, null, 1)");
        $this->addSql("INSERT INTO s10_furniture_types (id, name, description, reg_created_dt, reg_updated_dt, reg_status) VALUES (139, 'FREE ACCESS COLUMNA SPARKLE 120X7', null, null, null, 1)");
        $this->addSql("INSERT INTO `s20_brands_furniture_types` (`brand_id`, `furniture_type_id`) VALUES (6, 135)");
        $this->addSql("INSERT INTO `s20_brands_furniture_types` (`brand_id`, `furniture_type_id`) VALUES (6, 136)");
        $this->addSql("INSERT INTO `s20_brands_furniture_types` (`brand_id`, `furniture_type_id`) VALUES (1, 137)");
        $this->addSql("INSERT INTO `s20_brands_furniture_types` (`brand_id`, `furniture_type_id`) VALUES (5, 138)");
        $this->addSql("INSERT INTO `s20_brands_furniture_types` (`brand_id`, `furniture_type_id`) VALUES (4, 139)");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DELETE a FROM s10_furniture_types a WHERE a.id = 135");
        $this->addSql("DELETE a FROM s10_furniture_types a WHERE a.id = 136");
        $this->addSql("DELETE a FROM s10_furniture_types a WHERE a.id = 137");
        $this->addSql("DELETE a FROM s10_furniture_types a WHERE a.id = 138");
        $this->addSql("DELETE a FROM s10_furniture_types a WHERE a.id = 139");
        $this->addSql("DELETE a FROM s20_brands_furniture_types a WHERE a.brand_id = 6 AND a.furniture_type_id = 135");
        $this->addSql("DELETE a FROM s20_brands_furniture_types a WHERE a.brand_id = 6 AND a.furniture_type_id = 136");
        $this->addSql("DELETE a FROM s20_brands_furniture_types a WHERE a.brand_id = 1 AND a.furniture_type_id = 137");
        $this->addSql("DELETE a FROM s20_brands_furniture_types a WHERE a.brand_id = 5 AND a.furniture_type_id = 138");
        $this->addSql("DELETE a FROM s20_brands_furniture_types a WHERE a.brand_id = 4 AND a.furniture_type_id = 139");
    }
}
