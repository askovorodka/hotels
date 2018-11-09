<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180816113728 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            create or replace view deal_offer_price_min_price as
                select `dopwp`.`id`                     AS `id`,
                       `dopwp`.`deal_offer_id`          AS `deal_offer_id`,
                       `dopwp`.`title`                  AS `title`,
                       `dopwp`.`original_price`         AS `original_price`,
                       `dopwp`.`discount`               AS `discount`,
                       `dopwp`.`created_at`             AS `created_at`,
                       `dopwp`.`valid_date`             AS `valid_date`,
                       `dopwp`.`group_price_valid_date` AS `group_price_valid_date`,
                       `dopwp`.`max_coupone`            AS `max_coupone`,
                       `dopwp`.`price`                  AS `price`
                from `deal_offer_price_with_price` `dopwp`
                where (`dopwp`.`id` = (select `dp`.`id`
                                       from `deal_offer_price_with_price` `dp`
                                       where (`dp`.`deal_offer_id` = `dopwp`.`deal_offer_id`)
                                       order by `dp`.`price`
                                       limit 1));
        ');
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP VIEW deal_offer_price_min_price');
    }
}
