<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190308221408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF7979F0F470');
        $this->addSql('DROP INDEX IDX_9218FF7979F0F470 ON audit');
        $this->addSql('ALTER TABLE audit CHANGE auditorg_id org_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF79F4837C1B FOREIGN KEY (org_id) REFERENCES organisation (id)');
        $this->addSql('CREATE INDEX IDX_9218FF79F4837C1B ON audit (org_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF79F4837C1B');
        $this->addSql('DROP INDEX IDX_9218FF79F4837C1B ON audit');
        $this->addSql('ALTER TABLE audit CHANGE org_id auditorg_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF7979F0F470 FOREIGN KEY (auditorg_id) REFERENCES organisation (id)');
        $this->addSql('CREATE INDEX IDX_9218FF7979F0F470 ON audit (auditorg_id)');
    }
}
