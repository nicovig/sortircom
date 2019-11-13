<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190513101928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE outing ADD postal_code_id INT DEFAULT NULL, ADD latitude_id INT DEFAULT NULL, ADD longitude_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A10625BDBA6A61 FOREIGN KEY (postal_code_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A10625D70551C0 FOREIGN KEY (latitude_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A1062517AB44F2 FOREIGN KEY (longitude_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_F2A10625BDBA6A61 ON outing (postal_code_id)');
        $this->addSql('CREATE INDEX IDX_F2A10625D70551C0 ON outing (latitude_id)');
        $this->addSql('CREATE INDEX IDX_F2A1062517AB44F2 ON outing (longitude_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A10625BDBA6A61');
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A10625D70551C0');
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A1062517AB44F2');
        $this->addSql('DROP INDEX IDX_F2A10625BDBA6A61 ON outing');
        $this->addSql('DROP INDEX IDX_F2A10625D70551C0 ON outing');
        $this->addSql('DROP INDEX IDX_F2A1062517AB44F2 ON outing');
        $this->addSql('ALTER TABLE outing DROP postal_code_id, DROP latitude_id, DROP longitude_id');
    }
}
