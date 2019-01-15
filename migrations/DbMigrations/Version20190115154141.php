<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190115154141 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'PEND', t.`username` = '', t.`pswd` = '' WHERE t.`id` = 16");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'PEND', t.`username` = '', t.`pswd` = '' WHERE t.`id` = 30");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 15");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'PEND' WHERE t.`id` = 29");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Lester Ivan Rios Prieto', t.`username` = 'l.rios', t.`pswd` = '$2y$10\$d.Mf/.y87uBiYZj.QZsuNeueFdOHC.kySn6Ji2POfcfh50RT.TlTW' WHERE t.`id` = 16");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'José Francisco Peñaloza Mendez', t.`username` = 'f.penaloza', t.`pswd` = '$2y$10$10v5tv7etXOlbpYM.zWWq.qZXGnEbkg2zjHRjH4DqLVIxTatK9WOG' WHERE t.`id` = 30");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'Lester Ivan Rios Prieto' WHERE t.`id` = 15");
        $this->addSql("UPDATE `s10_clerks` t SET t.`name` = 'José Francisco Peñaloza Mendez' WHERE t.`id` = 29");
    }
}
