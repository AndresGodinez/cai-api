<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190116142737 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO s10_furniture_types (id, name, description, reg_created_dt, reg_updated_dt, reg_status) VALUES (141, 'PETITE BOUTIQUE', null, null, null, 1)");
        $this->addSql("INSERT INTO s10_furniture_types (id, name, description, reg_created_dt, reg_updated_dt, reg_status) VALUES (142, 'CABECERA', null, null, null, 1)");
        $this->addSql("INSERT INTO `s20_brands_furniture_types` (`brand_id`, `furniture_type_id`) VALUES (4, 141)");
        $this->addSql("INSERT INTO `s20_brands_furniture_types` (`brand_id`, `furniture_type_id`) VALUES (7, 142)");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DELETE a FROM s10_furniture_types a WHERE a.id = 141");
        $this->addSql("DELETE a FROM s10_furniture_types a WHERE a.id = 142");
        $this->addSql("DELETE a FROM s20_brands_furniture_types a WHERE a.brand_id = 4 AND a.furniture_type_id = 141");
        $this->addSql("DELETE a FROM s20_brands_furniture_types a WHERE a.brand_id = 7 AND a.furniture_type_id = 142");
    }
}
