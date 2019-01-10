<?php declare(strict_types=1);

namespace DbMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190110164800 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Eduardo Rivera Arana', t.`username` = 'e.rivera', t.`pswd` = '$2y$10\$d1EiedDtgsyrtA3DVALZRetx.8ZVXlDfqqXe/MLqU34WgkbeCTGc2' WHERE t.`id` = 2");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Diana Laura Chávez Martínez', t.`username` = 'diana.chavez', t.`pswd` = '$2y$10\$zSoxB5P4d/cQo4Y7t5Po0.rCsWD2msbpoOFC71/MfXa5J7q3FSzLG' WHERE t.`id` = 6");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'David Camilo Alejandro', t.`username` = 'd.camilo', t.`pswd` = '$2y$10$.t0o/LTi7s/spVtStQ48vuSBXeHBgTyGh3Il1ytjvji5nq/H2xXCi' WHERE t.`id` = 10");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Daniela Ruíz Urbina', t.`username` = 'd.ruiz', t.`pswd` = '$2y$10$9aO8YsOjBz26sN63VXbC.OriTPHJiDPPMV8fPZuTiE9MDWIWUj80G' WHERE t.`id` = 17");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Pedro de Jesús Quijano Ramírez', t.`username` = 'p.quijano', t.`pswd` = '$2y$10\$j7E/LKbmVKsGesZjrUjSDOIOzyiY6U.iB8vpUwAbqdyOc4voFa/76' WHERE t.`id` = 18");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Marcial Maciel Bobadilla', t.`username` = 'm.macial', t.`pswd` = '$2y$10\$lcR47Tp/O3Hvq.b1UBDrMupqzJ/BglEluXsuNBPyboYDdo7U7rEhi' WHERE t.`id` = 20");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Miguel Eliut Bañuelos Silva', t.`username` = 'm.banuelos', t.`pswd` = '$2y$10$9B1lzjlam4P4S975qVz.B.QJreAvO2KeDOyJ9b.WsbFGlfLE9hEty' WHERE t.`id` = 21");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'PEND', t.`username` = '', t.`pswd` = '' WHERE t.`id` = 24");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Jorge Enrique Padilla Romero', t.`username` = 'j.padilla', t.`pswd` = '$2y$10\$gqbhef0f6Orlg6GRT2HGae/MeKsdvqbVjw8MxgNmQ5jRGy8/HF1wa' WHERE t.`id` = 25");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'César Cassio Meléndez', t.`username` = 'c.cassio', t.`pswd` = '$2y$10\$Qw/2kQTrNd75hGCKllOWS.HK0RFMfPBDcOH6v5aR004G8Xzfz3P8.' WHERE t.`id` = 28");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Carlos Eduardo De la Vega Sánchez', t.`username` = 'c.vega', t.`pswd` = '$2y$10$0T7WwTYsHMOhIFY5uo3KNeg7C8kLvI4EvokJOmr0GdHpmacICNAty' WHERE t.`id` = 29");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'José Francisco Peñaloza Mendez' WHERE t.`id` = 30");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Jesús Eduardo del Real Villa' WHERE t.`id` = 34");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Alberto Medina Ortiz', t.`username` = 'a.medina', t.`pswd` = '$2y$10\$pLYXvjAk6IpOaNqNa6LYG.KykTG7KQbaqzrRO26U/9phhcXKVqvxm' WHERE t.`id` = 2");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'German Moreno Mendieta', t.`username` = 'g.moreno', t.`pswd` = '$2y$10\$sjL5omsok0uvvTUxh3eauOqNSQ77YyO0rU2EfKW9ECDpH.sIeml/C' WHERE t.`id` = 6");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Yhael Chona Sarmina', t.`username` = 'y.chona', t.`pswd` = '$2y$10\$t1LVyEeCTNE3QWHu4VUOZ.x213nEamHJmfmq81epLualWjguMlA0W' WHERE t.`id` = 10");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Leopoldo Agustín Alvarez Guillen', t.`username` = 'l.alvarez', t.`pswd` = '$2y$10$4LGqR55RnRLZkeiIuc5q6O9q33kDvumK1WM0Dfmr2oFf6NAgrtC8q' WHERE t.`id` = 17");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Jesús Manuel López Correa', t.`username` = 'j.lopez', t.`pswd` = '$2y$10\$FPPJbtRqJdy3l4VeNuEMU.m/b/EaYZC8e/8MrkLGXhlXnJjDg.iK.' WHERE t.`id` = 18");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Armando Duarte Ramirez', t.`username` = 'a.duarte', t.`pswd` = '$2y$10$4zgrRyDCzfki3nwWwhPCverlcPfuwCar.Q.g95Eb8m8wIrnachjTa' WHERE t.`id` = 20");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Daniel Sifuentes Delgado', t.`username` = 'd.sifuentes', t.`pswd` = '$2y$10\$gFuNw5pF0fFrBAKZzYwmpeOyZNzcz0YKLuzvXqTMDwH91tRYS0ZBO' WHERE t.`id` = 21");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Victor Jacobo Gallegos Vargas', t.`username` = 'v.gallegos', t.`pswd` = '$2y$10\$SL9zH1neTOpiRo05gzyuv.MUTdeRDFMQoFgTNDLtvFhTZBh0PG9H6' WHERE t.`id` = 24");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Roberto Gamaliel Lazama Javier', t.`username` = 'r.lazama', t.`pswd` = '$2y$10$91X1dKPC.OtZ9jnh3k5Tr.Xf6WmGmf5xiku13ERQuxZxFInq81JLy' WHERE t.`id` = 25");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Christian Iván Rincon Maturino', t.`username` = 'c.rincon', t.`pswd` = '$2y$10\$lZFI./HstFHUUNpUHHQJwekYeNBGpsEq1LZ8dhPecY74iWD2eYq5C' WHERE t.`id` = 28");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Enrique Alberto Macias Chavez', t.`username` = 'e.macias', t.`pswd` = '$2y$10\$njmAmjTv64aJsdvZ7kiav.G1GOTvGynE4YGVmW/c2uu6OQ0PUB74a' WHERE t.`id` = 29");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Francisco Peñaloza' WHERE t.`id` = 30");
        $this->addSql("UPDATE `s00_users` t SET t.`name` = 'Jesús Eduardo del Villar' WHERE t.`id` = 34");
    }
}
