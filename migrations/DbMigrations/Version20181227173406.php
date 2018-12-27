<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181227173406 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE s30_inventory_evidences ADD comments text NULL");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE s30_inventory_evidences DROP comments");
    }
}
