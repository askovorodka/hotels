<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180918114636 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE quota (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, date DATE NOT NULL COMMENT \'Дата квоты (день)\', quantity SMALLINT NOT NULL COMMENT \'Кол-во номеров по квоте в день\', quantity_free SMALLINT NOT NULL COMMENT \'Оставшееся кол-во номеров по квоте в день\', INDEX rooms_dates (room_id, date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quota ADD CONSTRAINT FK_6B71CBF454177093 FOREIGN KEY (room_id) REFERENCES room (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE quota');
    }
}
