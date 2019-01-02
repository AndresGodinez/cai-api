<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190102225744 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(\file_get_contents(__DIR__ . '/../sql-sources/data-s30_inventory_codes-line-03.sql'));
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('delete a from `s30_inventory_codes` a where a.`code` like "03%";');
    }
}
