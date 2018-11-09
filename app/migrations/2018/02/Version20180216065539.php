<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180216065539 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_category ADD system_name VARCHAR(255) NOT NULL');
        $this->addSql('UPDATE contact_category SET system_name = id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9C6985564FEFCDF0 ON contact_category (system_name)');
        $this->addSql('ALTER TABLE contact_type ADD system_name VARCHAR(255) NOT NULL');
        $this->addSql('UPDATE contact_type SET system_name = id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A421D5D64FEFCDF0 ON contact_type (system_name)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_9C6985564FEFCDF0 ON contact_category');
        $this->addSql('ALTER TABLE contact_category DROP system_name');
        $this->addSql('DROP INDEX UNIQ_A421D5D64FEFCDF0 ON contact_type');
        $this->addSql('ALTER TABLE contact_type DROP system_name');
    }
}
