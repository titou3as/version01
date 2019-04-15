<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415065633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contributor (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributor_document (contributor_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_EEAF0F407A19A357 (contributor_id), INDEX IDX_EEAF0F40C33F7837 (document_id), PRIMARY KEY(contributor_id, document_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, doi VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, summary LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE decision (id INT AUTO_INCREMENT NOT NULL, contributor_id INT DEFAULT NULL, document_id INT DEFAULT NULL, is_taken TINYINT(1) NOT NULL, content VARCHAR(255) NOT NULL, deposit VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_84ACBE487A19A357 (contributor_id), INDEX IDX_84ACBE48C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contributor_document ADD CONSTRAINT FK_EEAF0F407A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_document ADD CONSTRAINT FK_EEAF0F40C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE decision ADD CONSTRAINT FK_84ACBE487A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE decision ADD CONSTRAINT FK_84ACBE48C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributor_document DROP FOREIGN KEY FK_EEAF0F407A19A357');
        $this->addSql('ALTER TABLE decision DROP FOREIGN KEY FK_84ACBE487A19A357');
        $this->addSql('ALTER TABLE contributor_document DROP FOREIGN KEY FK_EEAF0F40C33F7837');
        $this->addSql('ALTER TABLE decision DROP FOREIGN KEY FK_84ACBE48C33F7837');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE contributor_document');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE decision');
    }
}
