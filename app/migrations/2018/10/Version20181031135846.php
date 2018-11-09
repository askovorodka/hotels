<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20181031135846
 *
 * @package Application\Migrations
 */
final class Version20181031135846 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE preset_pin (
              id INT AUTO_INCREMENT NOT NULL, 
              base_preset_id INT NOT NULL, 
              pinned_preset_id INT NOT NULL, 
              city_id INT DEFAULT NULL, 
              region_id INT DEFAULT NULL, 
              position INT NOT NULL, 
              is_active TINYINT(1) NOT NULL, 
              created_at DATETIME NOT NULL, 
              INDEX IDX_3DC512733441FE2 (base_preset_id), 
              INDEX IDX_3DC5127CA401F21 (pinned_preset_id), 
              PRIMARY KEY(id)
          ) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preset_pin ADD CONSTRAINT FK_3DC512733441FE2 FOREIGN KEY (base_preset_id) REFERENCES preset (id)');
        $this->addSql('ALTER TABLE preset_pin ADD CONSTRAINT FK_3DC5127CA401F21 FOREIGN KEY (pinned_preset_id) REFERENCES preset (id)');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE preset_pin');
    }
}
