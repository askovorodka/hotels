<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20181109074731
 *
 * @package Application\Migrations
 */
final class Version20181109074731 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_CE923A5F462CE4F5 ON federal_hotel_pin');
        $this->addSql('CREATE UNIQUE INDEX uniq_federal_hotel_pin_position_category ON federal_hotel_pin (position, pin_category_id)');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX uniq_federal_hotel_pin_position_category ON federal_hotel_pin');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE923A5F462CE4F5 ON federal_hotel_pin (position)');
    }
}
