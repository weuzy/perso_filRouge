<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203215456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE referentiels (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, presentation VARCHAR(255) NOT NULL, programme VARCHAR(255) NOT NULL, critere_devaluation VARCHAR(255) NOT NULL, critere_dadmission VARCHAR(255) NOT NULL, INDEX IDX_590B3B47D0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referentiels_groupe_de_competence (referentiels_id INT NOT NULL, groupe_de_competence_id INT NOT NULL, INDEX IDX_5FF71B51B8F4689C (referentiels_id), INDEX IDX_5FF71B51D0A2E50 (groupe_de_competence_id), PRIMARY KEY(referentiels_id, groupe_de_competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE referentiels ADD CONSTRAINT FK_590B3B47D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE referentiels_groupe_de_competence ADD CONSTRAINT FK_5FF71B51B8F4689C FOREIGN KEY (referentiels_id) REFERENCES referentiels (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referentiels_groupe_de_competence ADD CONSTRAINT FK_5FF71B51D0A2E50 FOREIGN KEY (groupe_de_competence_id) REFERENCES groupe_de_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo ADD langue VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD reference_agate VARCHAR(255) NOT NULL, ADD choix_de_la_fabrique VARCHAR(255) NOT NULL, ADD create_at DATETIME NOT NULL, ADD end_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE referentiels_groupe_de_competence DROP FOREIGN KEY FK_5FF71B51B8F4689C');
        $this->addSql('DROP TABLE referentiels');
        $this->addSql('DROP TABLE referentiels_groupe_de_competence');
        $this->addSql('ALTER TABLE promo DROP langue, DROP description, DROP reference_agate, DROP choix_de_la_fabrique, DROP create_at, DROP end_at');
    }
}
