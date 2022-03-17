<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317155931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE critere (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_critere (id INT AUTO_INCREMENT NOT NULL, id_student_id INT NOT NULL, id_critere_id INT NOT NULL, note_chaleur SMALLINT NOT NULL, note_gout SMALLINT NOT NULL, notequantite SMALLINT NOT NULL, noteacceuil SMALLINT NOT NULL, notediversite SMALLINT NOT NULL, notehygiene SMALLINT NOT NULL, INDEX IDX_925C35AB6E1ECFCD (id_student_id), INDEX IDX_925C35AB3BD5C57C (id_critere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_critere ADD CONSTRAINT FK_925C35AB6E1ECFCD FOREIGN KEY (id_student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student_critere ADD CONSTRAINT FK_925C35AB3BD5C57C FOREIGN KEY (id_critere_id) REFERENCES critere (id)');
        $this->addSql('ALTER TABLE student ADD note_repas SMALLINT NOT NULL, ADD note_valeur_environnement SMALLINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_critere DROP FOREIGN KEY FK_925C35AB3BD5C57C');
        $this->addSql('DROP TABLE critere');
        $this->addSql('DROP TABLE student_critere');
        $this->addSql('ALTER TABLE student DROP note_repas, DROP note_valeur_environnement');
    }
}
