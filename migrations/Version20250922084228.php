<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250922084228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'adding tables for prices prediction';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prices_predict (id INT AUTO_INCREMENT NOT NULL, date_data DATE DEFAULT NULL, avg1 NUMERIC(10, 2) DEFAULT NULL, avg1_foil NUMERIC(10, 2) DEFAULT NULL, idProduct INT DEFAULT NULL, INDEX IDX_FEFDEDC5C3F36F5F (idProduct), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prices_predict ADD CONSTRAINT FK_FEFDEDC5C3F36F5F FOREIGN KEY (idProduct) REFERENCES products (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prices_predict DROP FOREIGN KEY FK_FEFDEDC5C3F36F5F');
        $this->addSql('DROP TABLE prices_predict');
    }
}
