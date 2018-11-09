<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180226084002 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hotel_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_442DCBB32B36786B (title), INDEX is_active (is_active), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel ADD hotel_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9CC88D7CD FOREIGN KEY (hotel_category_id) REFERENCES hotel_category (id)');
        $this->addSql('CREATE INDEX IDX_3535ED9CC88D7CD ON hotel (hotel_category_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9CC88D7CD');
        $this->addSql('DROP TABLE hotel_category');
        $this->addSql('DROP INDEX IDX_3535ED9CC88D7CD ON hotel');
        $this->addSql('ALTER TABLE hotel DROP hotel_category_id');
    }
}
