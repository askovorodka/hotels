<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181031145124 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE federal_hotel_pin (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, `position` INT NOT NULL, exclude_cities_ids JSON DEFAULT NULL, exclude_regions_ids JSON DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_CE923A5F462CE4F5 (position), INDEX hotel_id (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE federal_hotel_pin ADD CONSTRAINT FK_CE923A5F3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE federal_hotel_pin');
    }
}
