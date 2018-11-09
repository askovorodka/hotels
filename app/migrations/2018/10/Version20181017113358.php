<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181017113358 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel ADD latitude NUMERIC(11, 8) DEFAULT NULL COMMENT \'Широта\', ADD longitude NUMERIC(11, 8) DEFAULT NULL COMMENT \'Долгота\', ADD country_code VARCHAR(3) DEFAULT NULL COMMENT \'Код страны\', ADD city_id INT DEFAULT NULL COMMENT \'ID города в нашем геосервисе\', ADD crm_city_id INT DEFAULT NULL COMMENT \'ID города в CRM\', ADD crm_city_name VARCHAR(255) DEFAULT NULL COMMENT \'Название города в CRM\'');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel DROP latitude, DROP longitude, DROP country_code, DROP city_id, DROP crm_city_id, DROP crm_city_name');
    }
}
