<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190518192547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE general_imp ADD generalimpaudit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE general_imp ADD CONSTRAINT FK_99AF05B65CDBAB9D FOREIGN KEY (generalimpaudit_id) REFERENCES audit (id)');
        $this->addSql('CREATE INDEX IDX_99AF05B65CDBAB9D ON general_imp (generalimpaudit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE general_imp DROP FOREIGN KEY FK_99AF05B65CDBAB9D');
        $this->addSql('DROP INDEX IDX_99AF05B65CDBAB9D ON general_imp');
        $this->addSql('ALTER TABLE general_imp DROP generalimpaudit_id');
    }
}
