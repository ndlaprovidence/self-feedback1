<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302071517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY eleve_ibfk_2');
        $this->addSql('CREATE TABLE qrcode (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, note_repas SMALLINT NOT NULL, note_valeur_environnement SMALLINT NOT NULL, note_commentaire VARCHAR(1000) DEFAULT NULL, note_date DATE NOT NULL, INDEX IDX_B723AF338F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF338F5EA509 FOREIGN KEY (classe_id) REFERENCES classes (id)');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE classes DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE classes CHANGE classe_id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE classes ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleve (eleve_Id INT AUTO_INCREMENT NOT NULL, classe_Id INT NOT NULL, note_Id INT DEFAULT NULL, INDEX classe_Id (classe_Id), INDEX note_Id (note_Id), PRIMARY KEY(eleve_Id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE notes (note_Id INT AUTO_INCREMENT NOT NULL, note_Valeur_Repas INT NOT NULL, note_Valeur_Environnement INT NOT NULL, note_Commentaire VARCHAR(1000) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, classe_Id INT NOT NULL, note_date DATE NOT NULL, INDEX classe_Id (classe_Id), PRIMARY KEY(note_Id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (user_Id INT AUTO_INCREMENT NOT NULL, user_Name VARCHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, user_Password VARCHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, user_Droit INT DEFAULT NULL, PRIMARY KEY(user_Id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT eleve_ibfk_1 FOREIGN KEY (classe_Id) REFERENCES classes (classe_Id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT eleve_ibfk_2 FOREIGN KEY (note_Id) REFERENCES notes (note_Id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT notes_ibfk_1 FOREIGN KEY (classe_Id) REFERENCES classes (classe_Id)');
        $this->addSql('DROP TABLE qrcode');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE classes MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE classes DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE classes CHANGE id classe_Id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE classes ADD PRIMARY KEY (classe_Id)');
    }
}
