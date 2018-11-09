<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180917152033 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            CREATE TABLE booking
            (
                id int PRIMARY KEY AUTO_INCREMENT,
                room_id int NOT NULL,
                quantity int DEFAULT 0 NOT NULL,
                start_date DATE NOT NULL,
                end_date DATE NOT NULL,
                purchase_id int NOT NULL,
                status int DEFAULT 0 NOT NULL,
                created_at DATETIME DEFAULT NOW() NOT NULL,
                CONSTRAINT booking_room_id_fk FOREIGN KEY (room_id) REFERENCES room (id)
            )            
        ');
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE booking');
    }
}
