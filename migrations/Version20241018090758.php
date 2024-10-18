<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018090758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE members_teams DROP FOREIGN KEY FK_30311F1FBD01F5ED');
        $this->addSql('ALTER TABLE members_teams DROP FOREIGN KEY FK_30311F1FD6365F12');
        $this->addSql('DROP TABLE members_teams');
        $this->addSql('ALTER TABLE members DROP FOREIGN KEY FK_45A0D2FFD6365F12');
        $this->addSql('DROP INDEX IDX_45A0D2FFD6365F12 ON members');
        $this->addSql('ALTER TABLE members ADD club_id INT DEFAULT NULL, CHANGE teams_id team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE members ADD CONSTRAINT FK_45A0D2FF296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE members ADD CONSTRAINT FK_45A0D2FF61190A32 FOREIGN KEY (club_id) REFERENCES clubs (id)');
        $this->addSql('CREATE INDEX IDX_45A0D2FF296CD8AE ON members (team_id)');
        $this->addSql('CREATE INDEX IDX_45A0D2FF61190A32 ON members (club_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE members_teams (members_id INT NOT NULL, teams_id INT NOT NULL, INDEX IDX_30311F1FBD01F5ED (members_id), INDEX IDX_30311F1FD6365F12 (teams_id), PRIMARY KEY(members_id, teams_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE members_teams ADD CONSTRAINT FK_30311F1FBD01F5ED FOREIGN KEY (members_id) REFERENCES members (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE members_teams ADD CONSTRAINT FK_30311F1FD6365F12 FOREIGN KEY (teams_id) REFERENCES teams (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE members DROP FOREIGN KEY FK_45A0D2FF296CD8AE');
        $this->addSql('ALTER TABLE members DROP FOREIGN KEY FK_45A0D2FF61190A32');
        $this->addSql('DROP INDEX IDX_45A0D2FF296CD8AE ON members');
        $this->addSql('DROP INDEX IDX_45A0D2FF61190A32 ON members');
        $this->addSql('ALTER TABLE members ADD teams_id INT DEFAULT NULL, DROP team_id, DROP club_id');
        $this->addSql('ALTER TABLE members ADD CONSTRAINT FK_45A0D2FFD6365F12 FOREIGN KEY (teams_id) REFERENCES teams (id)');
        $this->addSql('CREATE INDEX IDX_45A0D2FFD6365F12 ON members (teams_id)');
    }
}
