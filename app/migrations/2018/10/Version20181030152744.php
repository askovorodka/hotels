<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Миграция для создания и наполнения таблицы категорий подборок
 *
 * Class Version20181030152744
 *
 * @package Application\Migrations
 */
final class Version20181030152744 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            CREATE TABLE preset_category
            (
                id int PRIMARY KEY AUTO_INCREMENT,
                sysname varchar(255),
                description varchar(255),
                CONSTRAINT preset_category_sysname_uindex UNIQUE (sysname)
            )
            collate=utf8_unicode_ci
        ');
        $this->addSql("
            insert into preset_category
              (sysname, description)
            values
              ('main_page', 'Главная страница'),
              ('catalog_all', 'Каталог'),
              ('direction', 'Географическое направление'),
              ('marketing_stub', 'Маркетинговая заглушка'),
              ('marketing_banner', 'Маркетинговый баннер')
        ");
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE preset_category');
    }
}
