<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180816113442 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            create or replace view deal_offer_price_with_price as
                select `dop`.`id`                                                          AS `id`,
                       `dop`.`deal_offer_id`                                               AS `deal_offer_id`,
                       `dop`.`title`                                                       AS `title`,
                       `dop`.`original_price`                                              AS `original_price`,
                       `dop`.`discount`                                                    AS `discount`,
                       `dop`.`created_at`                                                  AS `created_at`,
                       `dop`.`valid_date`                                                  AS `valid_date`,
                       `dop`.`group_price_valid_date`                                      AS `group_price_valid_date`,
                       `dop`.`max_coupone`                                                 AS `max_coupone`,
                       round((`dop`.`original_price` * (1 - (`dop`.`discount` / 100))), 0) AS `price`
                from (((`deal_offer_price` `dop` join `deal_offer_price_room` `dopr` on ((`dop`.`id` =
                                                                                                          `dopr`.`deal_offer_price_id`))) join `deal_offer` `d` on ((
                  (`d`.`id` = `dop`.`deal_offer_id`) and (`d`.`is_active` = 1) and
                  (`d`.`valid_at` > now())))) join `room` `r` on (((`dopr`.`room_id` = `r`.`id`) and (`r`.`is_active` = 1))))
                where ((`dop`.`valid_date` > now()) and (`dop`.`max_coupone` >= 0))
        ');
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP VIEW deal_offer_price_with_price');
    }
}
