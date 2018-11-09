<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180816120343 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            create or replace view hotel_with_min_price as
                select `h`.`id`                  AS `id`,
                       `h`.`sysname`             AS `sysname`,
                       `h`.`administrative_area` AS `administrative_area`,
                       `h`.`hotel_category_id`   AS `hotel_category_id`,
                       `dop`.`deal_offer_id`     AS `deal_offer_id`,
                       `dop`.`id`                AS `deal_offer_price_id`,
                       `dop`.`original_price`    AS `original_price`,
                       `dop`.`discount`          AS `discount`,
                       `dop`.`price`             AS `price`
                from ((`hotel` `h` join `deal_offer` `o` on ((`h`.`id` =
                                                                              `o`.`hotel_id`))) join `deal_offer_price_min_price` `dop` on ((
                  `dop`.`deal_offer_id` = `o`.`id`)))
                where ((`h`.`is_active` = 1) and (`h`.`is_production` = 1))
        ');
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP VIEW hotel_with_min_price');
    }
}
