<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190416144124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributor ADD is_admin TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX UK_CONTRIBUTOR_DOCUMENT ON contributor_document');
        $this->addSql('DROP INDEX UK_DECISIONS ON decision');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributor DROP is_admin');
        $this->addSql('CREATE UNIQUE INDEX UK_CONTRIBUTOR_DOCUMENT ON contributor_document (contributor_id, document_id)');
        $this->addSql('CREATE UNIQUE INDEX UK_DECISIONS ON decision (document_id, contributor_id)');
    }
}
