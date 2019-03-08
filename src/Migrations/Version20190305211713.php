<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305211713 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE audit ADD auditorg_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF7979F0F470 FOREIGN KEY (auditorg_id) REFERENCES organisation (id)');
        $this->addSql('CREATE INDEX IDX_9218FF7979F0F470 ON audit (auditorg_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF7979F0F470');
        $this->addSql('DROP INDEX IDX_9218FF7979F0F470 ON audit');
        $this->addSql('ALTER TABLE audit DROP auditorg_id');
    }
}
