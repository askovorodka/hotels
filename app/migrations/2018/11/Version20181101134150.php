<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181101134150 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pin_category (id INT AUTO_INCREMENT NOT NULL, sysname VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_75AD93EAADD472C4 (sysname), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql("INSERT INTO pin_category (sysname, description, created_at, is_active) VALUES('banner', 'Pin banner', '2018-11-01 17:29:29', 1) ");
        $this->addSql("INSERT INTO pin_category (sysname, description, created_at, is_active) VALUES('catalog', 'Pin catalog', '2018-11-01 17:30:29', 1) ");

        $this->addSql('ALTER TABLE preset_pin ADD pin_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE preset_pin ADD CONSTRAINT FK_3DC5127303F96BF FOREIGN KEY (pin_category_id) REFERENCES pin_category (id)');
        $this->addSql('CREATE INDEX IDX_3DC5127303F96BF ON preset_pin (pin_category_id)');

        $this->addSql('ALTER TABLE local_hotel_pin ADD pin_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE local_hotel_pin ADD CONSTRAINT FK_334811D1303F96BF FOREIGN KEY (pin_category_id) REFERENCES pin_category (id)');
        $this->addSql('CREATE INDEX IDX_334811D1303F96BF ON local_hotel_pin (pin_category_id)');

        $this->addSql('ALTER TABLE federal_hotel_pin ADD pin_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE federal_hotel_pin ADD CONSTRAINT FK_CE923A5F303F96BF FOREIGN KEY (pin_category_id) REFERENCES pin_category (id)');
        $this->addSql('CREATE INDEX IDX_CE923A5F303F96BF ON federal_hotel_pin (pin_category_id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pin_category');
    }
}
