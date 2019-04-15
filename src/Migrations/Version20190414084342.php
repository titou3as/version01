<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190414084342 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE decision ADD contributor_id INT DEFAULT NULL, ADD document_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE decision ADD CONSTRAINT FK_84ACBE487A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE decision ADD CONSTRAINT FK_84ACBE48C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('CREATE INDEX IDX_84ACBE487A19A357 ON decision (contributor_id)');
        $this->addSql('CREATE INDEX IDX_84ACBE48C33F7837 ON decision (document_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE decision DROP FOREIGN KEY FK_84ACBE487A19A357');
        $this->addSql('ALTER TABLE decision DROP FOREIGN KEY FK_84ACBE48C33F7837');
        $this->addSql('DROP INDEX IDX_84ACBE487A19A357 ON decision');
        $this->addSql('DROP INDEX IDX_84ACBE48C33F7837 ON decision');
        $this->addSql('ALTER TABLE decision DROP contributor_id, DROP document_id');
    }
}
