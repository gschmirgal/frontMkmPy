<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250927091904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'adding log tables for prediction and error status in logsteps';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE logs_oracle (id INT AUTO_INCREMENT NOT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP, idStep INT DEFAULT NULL, idTask INT DEFAULT NULL, INDEX IDX_99CE53ED3044A0A2 (idStep), INDEX IDX_99CE53ED218385BB (idTask), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taskstypes (id INT AUTO_INCREMENT NOT NULL, task VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE logs_oracle ADD CONSTRAINT FK_99CE53ED3044A0A2 FOREIGN KEY (idStep) REFERENCES logsteps (id)');
        $this->addSql('ALTER TABLE logs_oracle ADD CONSTRAINT FK_99CE53ED218385BB FOREIGN KEY (idTask) REFERENCES taskstypes (id)');

        //initialisation des données
        $this->addSql("INSERT INTO `taskstypes` (`id`, `task`) VALUES (10, 'learn'), (20, 'predict' );");//initialisation des données
        $this->addSql("INSERT INTO `logsteps` (`id`, `step`) VALUES (99, 'error');");
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logs_oracle DROP FOREIGN KEY FK_99CE53ED3044A0A2');
        $this->addSql('ALTER TABLE logs_oracle DROP FOREIGN KEY FK_99CE53ED218385BB');
        $this->addSql('DROP TABLE logs_oracle');
        $this->addSql('DROP TABLE taskstypes');
        $this->addSql("DELETE FROM `logsteps` WHERE `id` = 99;");
    }
}
