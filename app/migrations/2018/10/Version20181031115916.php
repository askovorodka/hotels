<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20181031115916
 *
 * @package Application\Migrations
 */
final class Version20181031115916 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE local_hotel_pin (
                id INT AUTO_INCREMENT NOT NULL, 
                preset_id INT NOT NULL, 
                hotel_id INT NOT NULL, 
                city_id INT DEFAULT NULL, 
                region_id INT DEFAULT NULL, 
                position INT NOT NULL, 
                is_active TINYINT(1) NOT NULL, 
                created_at DATETIME NOT NULL, 
                INDEX IDX_334811D180688E6F (preset_id), 
                INDEX IDX_334811D13243BB18 (hotel_id), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE local_hotel_pin ADD CONSTRAINT FK_334811D180688E6F FOREIGN KEY (preset_id) REFERENCES preset (id)');
        $this->addSql('ALTER TABLE local_hotel_pin ADD CONSTRAINT FK_334811D13243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE local_hotel_pin');
    }
}
