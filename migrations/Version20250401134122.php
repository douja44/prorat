<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401134122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE admin CHANGE id_admin id_admin INT NOT NULL, CHANGE id id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin ADD CONSTRAINT FK_49CF2272BF396750 FOREIGN KEY (id) REFERENCES User (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_admin_user ON admin
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_49CF2272BF396750 ON admin (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_evenements_lieux ON evenements
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenements CHANGE id_evenement id_evenement INT NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE heure heure VARCHAR(255) NOT NULL, CHANGE typee typee VARCHAR(255) NOT NULL, CHANGE idLieu idLieu INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lieux CHANGE id_lieu id_lieu INT NOT NULL, CHANGE adresse adresse LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre CHANGE idoffre idoffre INT NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE date_debut date_debut VARCHAR(255) NOT NULL, CHANGE tauxReduction tauxReduction DOUBLE PRECISION NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organisateur DROP FOREIGN KEY fk_organisateur_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organisateur CHANGE id_organisateur id_organisateur INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_organisateur_user ON organisateur
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_53E6B6BCBF396750 ON organisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organisateur ADD CONSTRAINT fk_organisateur_user FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement DROP INDEX id_reservation, ADD INDEX IDX_48AA18485ADA84A2 (id_reservation)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement CHANGE id_paiement id_paiement INT NOT NULL, CHANGE id_reservation id_reservation INT DEFAULT NULL, CHANGE montant montant DOUBLE PRECISION NOT NULL, CHANGE statut statut VARCHAR(255) NOT NULL, CHANGE date_paiement date_paiement DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partenaire DROP FOREIGN KEY fk_partenaire_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partenaire CHANGE id_partenaire id_partenaire INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_partenaire_user ON partenaire
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7DA2A0A3BF396750 ON partenaire (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partenaire ADD CONSTRAINT fk_partenaire_user FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participants DROP FOREIGN KEY fk_participants_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participants CHANGE id_participant id_participant INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_participants_user ON participants
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6958AB6ABF396750 ON participants (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participants ADD CONSTRAINT fk_participants_user FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX num_reservation ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX id_lieu ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation CHANGE id_reservation id_reservation INT NOT NULL, CHANGE id_lieu id_lieu INT NOT NULL, CHANGE montant montant DOUBLE PRECISION NOT NULL, CHANGE heure_debut heure_debut VARCHAR(255) NOT NULL, CHANGE heure_fin heure_fin VARCHAR(255) NOT NULL, CHANGE id_organisateur id_organisateur INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_C454C68268161836 FOREIGN KEY (id_organisateur) REFERENCES Organisateur (id_organisateur) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX id_organisateur ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C454C68268161836 ON reservation (id_organisateur)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_retours_evenement ON retours
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_retours_participant ON retours
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE retours CHANGE id_retours id_retours INT NOT NULL, CHANGE id_participant id_participant INT NOT NULL, CHANGE id_evenement id_evenement INT NOT NULL, CHANGE contenu_retours contenu_retours VARCHAR(100) NOT NULL, CHANGE date_soumission_retours date_soumission_retours DATE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD type VARCHAR(255) NOT NULL, CHANGE id id INT NOT NULL, CHANGE failed_attempts failed_attempts INT NOT NULL, CHANGE lockout_end_time lockout_end_time DATETIME DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE Admin DROP FOREIGN KEY FK_49CF2272BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Admin DROP FOREIGN KEY FK_49CF2272BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Admin CHANGE id_admin id_admin INT AUTO_INCREMENT NOT NULL, CHANGE id id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_49cf2272bf396750 ON Admin
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_admin_user ON Admin (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Admin ADD CONSTRAINT FK_49CF2272BF396750 FOREIGN KEY (id) REFERENCES User (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Evenements CHANGE id_evenement id_evenement INT AUTO_INCREMENT NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE heure heure TIME NOT NULL, CHANGE typee typee VARCHAR(255) DEFAULT NULL, CHANGE idLieu idLieu INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_evenements_lieux ON Evenements (idLieu)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Lieux CHANGE id_lieu id_lieu INT AUTO_INCREMENT NOT NULL, CHANGE adresse adresse TEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Offre CHANGE idoffre idoffre INT AUTO_INCREMENT NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE date_debut date_debut VARCHAR(255) DEFAULT NULL, CHANGE tauxReduction tauxReduction DOUBLE PRECISION DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Organisateur DROP FOREIGN KEY FK_53E6B6BCBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Organisateur CHANGE id_organisateur id_organisateur INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_53e6b6bcbf396750 ON Organisateur
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_organisateur_user ON Organisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Organisateur ADD CONSTRAINT FK_53E6B6BCBF396750 FOREIGN KEY (id) REFERENCES User (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Paiement DROP INDEX IDX_48AA18485ADA84A2, ADD UNIQUE INDEX id_reservation (id_reservation)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Paiement CHANGE id_paiement id_paiement INT AUTO_INCREMENT NOT NULL, CHANGE id_reservation id_reservation INT NOT NULL, CHANGE montant montant NUMERIC(10, 2) NOT NULL, CHANGE statut statut VARCHAR(255) DEFAULT 'En attente', CHANGE date_paiement date_paiement DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Partenaire DROP FOREIGN KEY FK_7DA2A0A3BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Partenaire CHANGE id_partenaire id_partenaire INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_7da2a0a3bf396750 ON Partenaire
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_partenaire_user ON Partenaire (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Partenaire ADD CONSTRAINT FK_7DA2A0A3BF396750 FOREIGN KEY (id) REFERENCES User (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Participants DROP FOREIGN KEY FK_6958AB6ABF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Participants CHANGE id_participant id_participant INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_6958ab6abf396750 ON Participants
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_participants_user ON Participants (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Participants ADD CONSTRAINT FK_6958AB6ABF396750 FOREIGN KEY (id) REFERENCES User (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Reservation DROP FOREIGN KEY FK_C454C68268161836
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Reservation DROP FOREIGN KEY FK_C454C68268161836
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Reservation CHANGE id_reservation id_reservation INT AUTO_INCREMENT NOT NULL, CHANGE id_organisateur id_organisateur INT DEFAULT 1, CHANGE id_lieu id_lieu INT DEFAULT NULL, CHANGE montant montant NUMERIC(10, 3) DEFAULT '500.000', CHANGE heure_debut heure_debut TIME DEFAULT NULL, CHANGE heure_fin heure_fin TIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX num_reservation ON Reservation (num_reservation)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX id_lieu ON Reservation (id_lieu)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_c454c68268161836 ON Reservation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX id_organisateur ON Reservation (id_organisateur)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Reservation ADD CONSTRAINT FK_C454C68268161836 FOREIGN KEY (id_organisateur) REFERENCES Organisateur (id_organisateur) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Retours CHANGE id_retours id_retours INT AUTO_INCREMENT NOT NULL, CHANGE id_participant id_participant INT DEFAULT NULL, CHANGE id_evenement id_evenement INT DEFAULT NULL, CHANGE contenu_retours contenu_retours VARCHAR(100) DEFAULT NULL, CHANGE date_soumission_retours date_soumission_retours DATE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_retours_evenement ON Retours (id_evenement)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_retours_participant ON Retours (id_participant)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE User DROP type, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE failed_attempts failed_attempts INT DEFAULT 0, CHANGE lockout_end_time lockout_end_time BIGINT DEFAULT NULL
        SQL);
    }
}
