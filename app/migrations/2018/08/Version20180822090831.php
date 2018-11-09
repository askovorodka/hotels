<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180822090831 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            create or replace view room_amenities_with_price as
                select `h`.`id`                  AS `id`,
                       `h`.`sysname`             AS `sysname`,
                       `h`.`administrative_area` AS `administrative_area`,
                       `h`.`hotel_category_id`   AS `hotel_category_id`,
                       `h`.`original_price`      AS `original_price`,
                       `h`.`discount`            AS `discount`,
                       `h`.`price`               AS `price`,
                       `a`.`id`                  AS `amenity_id`
                from `hotel_with_min_price` `h`
                       join `room` `r` on `r`.`hotel_id` = `h`.`id`
                                            and `r`.`is_active` = 1
                       join `deal_offer_price_room` `room2` on `r`.`id` = `room2`.`room_id`
                       join `deal_offer_price` `price` on `room2`.`deal_offer_price_id` = `price`.`id`
                                                            and `price`.`valid_date` > now()
                                                            and `price`.`max_coupone` >= 0
                       join `deal_offer` `o` on `price`.`deal_offer_id` = `o`.`id`
                                                  and `o`.`is_active` = 1
                                                  and `o`.`valid_at` > now()
                       join `room_amenities` `ra` on `r`.`id` = `ra`.`room_id`
                                                       and `ra`.`is_active` = 1
                       join `amenity` `a` on `ra`.`amenity_id` = `a`.`id`
                                               and `a`.is_active = 1
        ');
    }

    public function down(Schema $schema)
    {
        /** @see Version20180816122929::down() */
    }
}
