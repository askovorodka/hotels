<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180829152654 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            alter table hotel
              add column coordinates varchar(32) null comment \'Координаты\' after postal_code,
              add column metro varchar(128) null comment \'Ближайшая станция метро\' after coordinates
        ');
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            alter table hotel
              drop column coordinates,
              drop column metro
        ');
    }
}
