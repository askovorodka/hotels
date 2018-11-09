<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180312072731 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_photos ADD area_width INT DEFAULT NULL, ADD area_height INT DEFAULT NULL, ADD offset_top INT DEFAULT NULL, ADD offset_left INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD width INT DEFAULT NULL, ADD height INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room_photos ADD area_width INT DEFAULT NULL, ADD area_height INT DEFAULT NULL, ADD offset_top INT DEFAULT NULL, ADD offset_left INT DEFAULT NULL');
        $this->addSql('ALTER TABLE preset_photo ADD area_width INT DEFAULT NULL, ADD area_height INT DEFAULT NULL, ADD offset_top INT DEFAULT NULL, ADD offset_left INT DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_photos DROP area_width, DROP area_height, DROP offset_top, DROP offset_left');
        $this->addSql('ALTER TABLE photo DROP width, DROP height');
        $this->addSql('ALTER TABLE preset_photo DROP area_width, DROP area_height, DROP offset_top, DROP offset_left');
        $this->addSql('ALTER TABLE room_photos DROP area_width, DROP area_height, DROP offset_top, DROP offset_left');
    }
}
