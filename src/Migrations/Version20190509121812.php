<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190509121812 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE outing ADD site_id INT DEFAULT NULL, ADD city_id INT DEFAULT NULL, ADD place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A10625F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A106258BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A10625DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_F2A10625F6BD1646 ON outing (site_id)');
        $this->addSql('CREATE INDEX IDX_F2A106258BAC62AF ON outing (city_id)');
        $this->addSql('CREATE INDEX IDX_F2A10625DA6A219 ON outing (place_id)');
        $this->addSql('ALTER TABLE participant CHANGE password password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A10625F6BD1646');
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A106258BAC62AF');
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A10625DA6A219');
        $this->addSql('DROP INDEX IDX_F2A10625F6BD1646 ON outing');
        $this->addSql('DROP INDEX IDX_F2A106258BAC62AF ON outing');
        $this->addSql('DROP INDEX IDX_F2A10625DA6A219 ON outing');
        $this->addSql('ALTER TABLE outing DROP site_id, DROP city_id, DROP place_id');
        $this->addSql('ALTER TABLE participant CHANGE password password VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
