<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181221190350 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(\file_get_contents(__DIR__ . '/../sql-sources/initial-data-s10_states.sql'));
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("TRUNCATE s10_states");
    }
}
