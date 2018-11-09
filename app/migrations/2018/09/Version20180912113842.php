<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180912113842 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            alter table purchase
              drop FOREIGN KEY FK_6117D13BB0416574,
              drop FOREIGN KEY FK_6117D13B953E1CE9
        ');
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BB0416574 FOREIGN KEY (deal_offer_id) REFERENCES deal_offer (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B953E1CE9 FOREIGN KEY (deal_offer_price_id) REFERENCES deal_offer_price (id)');
    }
}
