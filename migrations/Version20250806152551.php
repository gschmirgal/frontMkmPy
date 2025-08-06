<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250806152551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create initial cards and logs tables and initial data';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expansions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logs (id INT AUTO_INCREMENT NOT NULL, date_import DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, date_import_file DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, date_data DATE DEFAULT NULL, idStep INT DEFAULT NULL, INDEX IDX_F08FC65C3044A0A2 (idStep), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logsteps (id INT AUTO_INCREMENT NOT NULL, step VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prices (id INT AUTO_INCREMENT NOT NULL, date_data DATE DEFAULT NULL, avg NUMERIC(10, 2) NOT NULL, low NUMERIC(10, 2) NOT NULL, trend NUMERIC(10, 2) NOT NULL, avg1 NUMERIC(10, 2) NOT NULL, avg7 NUMERIC(10, 2) NOT NULL, avg30 NUMERIC(10, 2) NOT NULL, avg_foil NUMERIC(10, 2) NOT NULL, low_foil NUMERIC(10, 2) NOT NULL, trend_foil NUMERIC(10, 2) NOT NULL, avg1_foil NUMERIC(10, 2) NOT NULL, avg7_foil NUMERIC(10, 2) NOT NULL, avg30_foil NUMERIC(10, 2) NOT NULL, idProduct INT DEFAULT NULL, idLog INT DEFAULT NULL, INDEX IDX_E4CB6D59C3F36F5F (idProduct), INDEX IDX_E4CB6D59AE777542 (idLog), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, id_meta_card INT NOT NULL, date_added DATETIME NOT NULL, idExpansion INT DEFAULT NULL, INDEX IDX_B3BA5A5AC837024 (idExpansion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE logs ADD CONSTRAINT FK_F08FC65C3044A0A2 FOREIGN KEY (idStep) REFERENCES logsteps (id)');
        $this->addSql('ALTER TABLE prices ADD CONSTRAINT FK_E4CB6D59C3F36F5F FOREIGN KEY (idProduct) REFERENCES products (id)');
        $this->addSql('ALTER TABLE prices ADD CONSTRAINT FK_E4CB6D59AE777542 FOREIGN KEY (idLog) REFERENCES logs (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AC837024 FOREIGN KEY (idExpansion) REFERENCES expansions (id)');

        //initialisation des données
        $this->addSql("INSERT INTO `logsteps` (`id`, `step`) VALUES (10, 'ongoing'), (50, 'finished'), (90, 'too early');");
        $this->addSql("INSERT INTO `logs` (`id`, `date_import`, `date_import_file`, `date_data`, `idStep`) VALUES (1, '2025-01-01 00:00:00', '2024-12-31 22:00:00', '2025-01-01', 50)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logs DROP FOREIGN KEY FK_F08FC65C3044A0A2');
        $this->addSql('ALTER TABLE prices DROP FOREIGN KEY FK_E4CB6D59C3F36F5F');
        $this->addSql('ALTER TABLE prices DROP FOREIGN KEY FK_E4CB6D59AE777542');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AC837024');
        $this->addSql('DROP TABLE expansions');
        $this->addSql('DROP TABLE logs');
        $this->addSql('DROP TABLE logsteps');
        $this->addSql('DROP TABLE prices');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
