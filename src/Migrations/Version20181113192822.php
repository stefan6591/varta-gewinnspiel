<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181113192822 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contest ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE contest_participant ADD contest_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE contest_participant ADD CONSTRAINT FK_55FD8DA01CD0F0DE FOREIGN KEY (contest_id) REFERENCES contest (id)');
        $this->addSql('CREATE INDEX IDX_55FD8DA01CD0F0DE ON contest_participant (contest_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contest DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE contest_participant DROP FOREIGN KEY FK_55FD8DA01CD0F0DE');
        $this->addSql('DROP INDEX IDX_55FD8DA01CD0F0DE ON contest_participant');
        $this->addSql('ALTER TABLE contest_participant DROP contest_id, DROP created_at, DROP updated_at');
    }
}
