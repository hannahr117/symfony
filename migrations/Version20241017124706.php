<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017124706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students ADD class_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('CREATE INDEX IDX_A4698DB2EA000B10 ON students (class_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2EA000B10');
        $this->addSql('DROP INDEX IDX_A4698DB2EA000B10 ON students');
        $this->addSql('ALTER TABLE students DROP class_id');
    }
}
