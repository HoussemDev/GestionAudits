<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312205803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE certificat ADD audit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE certificat ADD CONSTRAINT FK_27448F77BD29F359 FOREIGN KEY (audit_id) REFERENCES audit (id)');
        $this->addSql('CREATE INDEX IDX_27448F77BD29F359 ON certificat (audit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE certificat DROP FOREIGN KEY FK_27448F77BD29F359');
        $this->addSql('DROP INDEX IDX_27448F77BD29F359 ON certificat');
        $this->addSql('ALTER TABLE certificat DROP audit_id');
    }
}
