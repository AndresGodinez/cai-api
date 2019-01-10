<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190110210832 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO s10_furniture_types (id, name, description, reg_created_dt, reg_updated_dt, reg_status) VALUES (133, 'WHITE WALL', null, null, null, 1)");
        $this->addSql("INSERT INTO s10_furniture_types (id, name, description, reg_created_dt, reg_updated_dt, reg_status) VALUES (134, 'WHITE WALL 8 FT', null, null, null, 1)");
        $this->addSql("INSERT INTO s20_brands_furniture_types (id, brand_id, furniture_type_id) VALUES (147, 4, 133)");
        $this->addSql("INSERT INTO s20_brands_furniture_types (id, brand_id, furniture_type_id) VALUES (148, 4, 134)");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DELETE a FROM s10_furniture_types a WHERE a.id = 134");
        $this->addSql("DELETE a FROM s10_furniture_types a WHERE a.id = 133");
        $this->addSql("DELETE a FROM s20_brands_furniture_types a WHERE a.brand_id = 4 AND a.furniture_type_id = 133");
        $this->addSql("DELETE a FROM s20_brands_furniture_types a WHERE a.brand_id = 4 AND a.furniture_type_id = 134");
    }
}
