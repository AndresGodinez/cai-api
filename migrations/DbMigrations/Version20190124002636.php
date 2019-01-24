<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124002636 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Ulises Irepan Quintero', t.`username` = 'u.quintero', t.`pswd` = '$2y$10\$sNg8mOzeN9hA/c5t4zDtyeqc0Kzf/6XL6oRLtglQCUiCjgt9flqDe' WHERE t.`id` = 24");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Ulises Irepan Quintero' WHERE t.`id` = 23");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'PEND', t.`username` = '', t.`pswd` = '' WHERE t.`id` = 24");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 23");
    }
}
