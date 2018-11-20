<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181120154309 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contest ADD question_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE contest ADD CONSTRAINT FK_1A95CB51E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1A95CB51E27F6BF ON contest (question_id)');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E1CD0F0DE');
        $this->addSql('DROP INDEX UNIQ_B6F7494E1CD0F0DE ON question');
        $this->addSql('ALTER TABLE question DROP contest_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contest DROP FOREIGN KEY FK_1A95CB51E27F6BF');
        $this->addSql('DROP INDEX UNIQ_1A95CB51E27F6BF ON contest');
        $this->addSql('ALTER TABLE contest DROP question_id');
        $this->addSql('ALTER TABLE question ADD contest_id CHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E1CD0F0DE FOREIGN KEY (contest_id) REFERENCES contest (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6F7494E1CD0F0DE ON question (contest_id)');
    }
}
