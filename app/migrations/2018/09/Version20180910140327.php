<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180910140327 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, deal_offer_id INT NOT NULL, deal_offer_price_id INT NOT NULL, cl_client_id INT NOT NULL, purchase_date DATETIME NOT NULL, status SMALLINT DEFAULT NULL, total_price INT NOT NULL, INDEX IDX_6117D13BB0416574 (deal_offer_id), INDEX IDX_6117D13B953E1CE9 (deal_offer_price_id), INDEX status (status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BB0416574 FOREIGN KEY (deal_offer_id) REFERENCES deal_offer (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B953E1CE9 FOREIGN KEY (deal_offer_price_id) REFERENCES deal_offer_price (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE purchase');
    }
}
