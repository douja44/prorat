<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250417193106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP FOREIGN KEY messages_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP FOREIGN KEY messages_ibfk_2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin DROP FOREIGN KEY fk_admin_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_admin_user ON admin
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin ADD id INT DEFAULT NULL, CHANGE Id_user id_admin INT NOT NULL, CHANGE createdAt created_at DATE NOT NULL, ADD PRIMARY KEY (id_admin)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin ADD CONSTRAINT FK_49CF2272BF396750 FOREIGN KEY (id) REFERENCES User (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_49CF2272BF396750 ON admin (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billets DROP FOREIGN KEY FK_EventID
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billets CHANGE id_billet id_billet INT NOT NULL, CHANGE id_evenement id_evenement INT DEFAULT NULL, CHANGE qrCodePath qrCodePath VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_evenement_id ON billets
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8072A2F48B13D439 ON billets (id_evenement)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billets ADD CONSTRAINT FK_EventID FOREIGN KEY (id_evenement) REFERENCES evenements (id_evenement) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idoffre ON contrat
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX id_user ON contrat
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX id_event ON contrat
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrat CHANGE conditions_contrat conditions_contrat LONGTEXT NOT NULL, CHANGE idoffre idoffre INT NOT NULL, CHANGE id_user idUser INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_evenement ON evaluation
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_participant ON evaluation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evaluation CHANGE id_evaluation id_evaluation INT NOT NULL, CHANGE id_participant id_participant INT NOT NULL, CHANGE id_evenement id_evenement INT NOT NULL, CHANGE note_contenu note_contenu DOUBLE PRECISION NOT NULL, CHANGE note_interaction note_interaction DOUBLE PRECISION NOT NULL, CHANGE note_moyenne note_moyenne DOUBLE PRECISION NOT NULL, CHANGE note_soumission note_soumission DOUBLE PRECISION NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenements DROP FOREIGN KEY fk_evenements_lieux
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
            ALTER TABLE offre CHANGE description description LONGTEXT NOT NULL, CHANGE date_debut date_debut VARCHAR(255) NOT NULL, CHANGE tauxReduction tauxReduction DOUBLE PRECISION NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organisateur DROP FOREIGN KEY fk_organisateur_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_organisateur_user ON organisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organisateur ADD id_organisateur INT AUTO_INCREMENT NOT NULL, CHANGE id_user id INT DEFAULT NULL, ADD PRIMARY KEY (id_organisateur)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organisateur ADD CONSTRAINT FK_53E6B6BCBF396750 FOREIGN KEY (id) REFERENCES User (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_53E6B6BCBF396750 ON organisateur (id)
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
            DROP INDEX fk_partenaire_user ON partenaire
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partenaire ADD id_partenaire INT AUTO_INCREMENT NOT NULL, CHANGE id_user id INT DEFAULT NULL, ADD PRIMARY KEY (id_partenaire)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partenaire ADD CONSTRAINT FK_7DA2A0A3BF396750 FOREIGN KEY (id) REFERENCES User (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7DA2A0A3BF396750 ON partenaire (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participants DROP FOREIGN KEY fk_participants_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_participants_user ON participants
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participants CHANGE id_user id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participants ADD CONSTRAINT FK_6958AB6ABF396750 FOREIGN KEY (id) REFERENCES User (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6958AB6ABF396750 ON participants (id)
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
            ALTER TABLE user MODIFY Id_user INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD roles JSON NOT NULL COMMENT '(DC2Type:json)', CHANGE date_naiss date_naiss DATE DEFAULT NULL, CHANGE failed_attempts failed_attempts INT NOT NULL, CHANGE lockout_end_time lockout_end_time DATETIME DEFAULT NULL, CHANGE Id_user id INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD PRIMARY KEY (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, message_text TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT 'sent' COLLATE `utf8mb4_general_ci`, INDEX sender_id (sender_id), INDEX receiver_id (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT messages_ibfk_1 FOREIGN KEY (sender_id) REFERENCES user (Id_user) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT messages_ibfk_2 FOREIGN KEY (receiver_id) REFERENCES user (Id_user) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Admin DROP FOREIGN KEY FK_49CF2272BF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_49CF2272BF396750 ON Admin
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON Admin
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Admin DROP id, CHANGE id_admin Id_user INT NOT NULL, CHANGE created_at createdAt DATE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Admin ADD CONSTRAINT fk_admin_user FOREIGN KEY (Id_user) REFERENCES user (Id_user) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_admin_user ON Admin (Id_user)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Billets DROP FOREIGN KEY FK_8072A2F48B13D439
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Billets CHANGE id_billet id_billet INT AUTO_INCREMENT NOT NULL, CHANGE id_evenement id_evenement INT NOT NULL, CHANGE qrCodePath qrCodePath VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_8072a2f48b13d439 ON Billets
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_evenement_id ON Billets (id_evenement)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Billets ADD CONSTRAINT FK_8072A2F48B13D439 FOREIGN KEY (id_evenement) REFERENCES Evenements (id_evenement) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Contrat CHANGE idoffre idoffre INT DEFAULT NULL, CHANGE conditions_contrat conditions_contrat TEXT NOT NULL, CHANGE idUser id_user INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX idoffre ON Contrat (idoffre)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX id_user ON Contrat (id_user)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX id_event ON Contrat (id_event)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Evaluation CHANGE id_evaluation id_evaluation INT AUTO_INCREMENT NOT NULL, CHANGE id_participant id_participant INT DEFAULT NULL, CHANGE id_evenement id_evenement INT DEFAULT NULL, CHANGE note_contenu note_contenu NUMERIC(5, 2) DEFAULT NULL, CHANGE note_interaction note_interaction NUMERIC(5, 2) DEFAULT NULL, CHANGE note_moyenne note_moyenne NUMERIC(5, 2) DEFAULT NULL, CHANGE note_soumission note_soumission NUMERIC(5, 2) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_evenement ON Evaluation (id_evenement)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_participant ON Evaluation (id_participant)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Evenements CHANGE id_evenement id_evenement INT AUTO_INCREMENT NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE heure heure TIME NOT NULL, CHANGE typee typee VARCHAR(255) DEFAULT NULL, CHANGE idLieu idLieu INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Evenements ADD CONSTRAINT fk_evenements_lieux FOREIGN KEY (idLieu) REFERENCES lieux (id_lieu)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_evenements_lieux ON Evenements (idLieu)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Lieux CHANGE id_lieu id_lieu INT AUTO_INCREMENT NOT NULL, CHANGE adresse adresse TEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Offre CHANGE description description TEXT DEFAULT NULL, CHANGE date_debut date_debut VARCHAR(255) DEFAULT NULL, CHANGE tauxReduction tauxReduction DOUBLE PRECISION DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Organisateur MODIFY id_organisateur INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Organisateur DROP FOREIGN KEY FK_53E6B6BCBF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_53E6B6BCBF396750 ON Organisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON Organisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Organisateur DROP id_organisateur, CHANGE id id_user INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Organisateur ADD CONSTRAINT fk_organisateur_user FOREIGN KEY (id_user) REFERENCES user (Id_user) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_organisateur_user ON Organisateur (id_user)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Paiement DROP INDEX IDX_48AA18485ADA84A2, ADD UNIQUE INDEX id_reservation (id_reservation)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Paiement CHANGE id_paiement id_paiement INT AUTO_INCREMENT NOT NULL, CHANGE id_reservation id_reservation INT NOT NULL, CHANGE montant montant NUMERIC(10, 2) NOT NULL, CHANGE statut statut VARCHAR(255) DEFAULT 'En attente', CHANGE date_paiement date_paiement DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Partenaire MODIFY id_partenaire INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Partenaire DROP FOREIGN KEY FK_7DA2A0A3BF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7DA2A0A3BF396750 ON Partenaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON Partenaire
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Partenaire DROP id_partenaire, CHANGE id id_user INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Partenaire ADD CONSTRAINT fk_partenaire_user FOREIGN KEY (id_user) REFERENCES user (Id_user) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_partenaire_user ON Partenaire (id_user)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Participants DROP FOREIGN KEY FK_6958AB6ABF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6958AB6ABF396750 ON Participants
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Participants CHANGE id id_user INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Participants ADD CONSTRAINT fk_participants_user FOREIGN KEY (id_user) REFERENCES user (Id_user) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_participants_user ON Participants (id_user)
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
            ALTER TABLE User MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON User
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE User DROP roles, CHANGE date_naiss date_naiss DATE NOT NULL, CHANGE failed_attempts failed_attempts INT DEFAULT 0, CHANGE lockout_end_time lockout_end_time BIGINT DEFAULT NULL, CHANGE id Id_user INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE User ADD PRIMARY KEY (Id_user)
        SQL);
    }
}
