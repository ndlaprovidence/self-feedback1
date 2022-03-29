<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329101022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, classe_libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE critere (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qrcode (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, note_repas SMALLINT NOT NULL, note_valeur_environnement SMALLINT NOT NULL, note_commentaire VARCHAR(1000) DEFAULT NULL, note_date DATE NOT NULL, note_chaleur SMALLINT NOT NULL, note_gout SMALLINT NOT NULL, notequantite SMALLINT NOT NULL, noteacceuil SMALLINT NOT NULL, notediversite SMALLINT NOT NULL, notehygiene SMALLINT NOT NULL, INDEX IDX_B723AF338F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_critere (id INT AUTO_INCREMENT NOT NULL, id_student_id INT NOT NULL, id_critere_id INT NOT NULL, note_chaleur SMALLINT NOT NULL, note_gout SMALLINT NOT NULL, notequantite SMALLINT NOT NULL, noteacceuil SMALLINT NOT NULL, notediversite SMALLINT NOT NULL, notehygiene SMALLINT NOT NULL, INDEX IDX_925C35AB6E1ECFCD (id_student_id), INDEX IDX_925C35AB3BD5C57C (id_critere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF338F5EA509 FOREIGN KEY (classe_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE student_critere ADD CONSTRAINT FK_925C35AB6E1ECFCD FOREIGN KEY (id_student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student_critere ADD CONSTRAINT FK_925C35AB3BD5C57C FOREIGN KEY (id_critere_id) REFERENCES critere (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF338F5EA509');
        $this->addSql('ALTER TABLE student_critere DROP FOREIGN KEY FK_925C35AB3BD5C57C');
        $this->addSql('ALTER TABLE student_critere DROP FOREIGN KEY FK_925C35AB6E1ECFCD');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE critere');
        $this->addSql('DROP TABLE qrcode');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_critere');
        $this->addSql('DROP TABLE user');
    }
}