<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180417083716 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
          CREATE TABLE deal_offer_partner_manager
          (
            id int auto_increment primary key,
            deal_offer_id int not null,
            manager_email varchar(180) not null,
            foreign key (deal_offer_id) references deal_offer(id) on delete cascade,
            unique key(deal_offer_id, manager_email)
          ) 
          DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE deal_offer_partner_manager');
    }
}
