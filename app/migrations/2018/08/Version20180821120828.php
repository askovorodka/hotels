<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180821120828 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            create or replace view hotel_amenities_with_price as
                select `h`.`id`                  AS `id`,
                       `h`.`sysname`             AS `sysname`,
                       `h`.`administrative_area` AS `administrative_area`,
                       `h`.`hotel_category_id`   AS `hotel_category_id`,
                       `h`.`deal_offer_id`       AS `deal_offer_id`,
                       `h`.`deal_offer_price_id` AS `deal_offer_price_id`,
                       `h`.`original_price`      AS `original_price`,
                       `h`.`discount`            AS `discount`,
                       `h`.`price`               AS `price`,
                       `a`.`id`                  AS `amenity_id`
                from `hotel_with_min_price` `h`
                       join `hotel_amenities` `ha` on `ha`.`hotel_id` = `h`.`id` and `ha`.is_active = 1
                       join `amenity` `a` on `ha`.`amenity_id` = `a`.`id` and `a`.is_active = 1
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        /** @see Version20180816122339::down() */
    }
}
