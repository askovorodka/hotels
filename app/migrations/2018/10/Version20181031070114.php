<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20181031070114
 *
 * @package Application\Migrations
 */
final class Version20181031070114 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE preset ADD preset_category_id int NULL');
        $this->addSql('
            ALTER TABLE preset
            ADD CONSTRAINT preset_preset_category_id_fk
            FOREIGN KEY (preset_category_id) REFERENCES preset_category (id)
        ');
        $this->addSql('ALTER TABLE preset ALTER COLUMN is_active SET DEFAULT 0');
        $this->addSql('ALTER TABLE preset ADD params json NULL');
        $this->addSql('ALTER TABLE preset MODIFY sysname varchar(255)');
        $this->addSql('ALTER TABLE preset ADD region_id int NULL');
        $this->addSql('ALTER TABLE preset ADD city_id int NULL');
        $this->addSql('ALTER TABLE preset MODIFY is_active tinyint(1) NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE preset MODIFY title varchar(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE preset DROP FOREIGN KEY preset_preset_category_id_fk');
        $this->addSql('
            ALTER TABLE preset
            drop column city_id,
            drop column region_id,
            drop column params,
            drop column preset_category_id
        ');
    }
}
