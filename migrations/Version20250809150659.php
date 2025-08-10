<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250809150659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'implement ScryfallProducts table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scryfall_products (id VARCHAR(36) NOT NULL, card_market_id_id INT DEFAULT NULL, oracle_id VARCHAR(36) NOT NULL, scryfall_uri VARCHAR(255) NOT NULL, img_normal_uri VARCHAR(255) NOT NULL, img_large_uri VARCHAR(255) NOT NULL, img_png_uri VARCHAR(255) NOT NULL, img_artcrop_uri VARCHAR(255) NOT NULL, img_bordercrop_uri VARCHAR(255) NOT NULL, reserved TINYINT(1) NOT NULL, INDEX IDX_F32CB476A4578F27 (card_market_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scryfall_products ADD CONSTRAINT FK_F32CB476A4578F27 FOREIGN KEY (card_market_id_id) REFERENCES products (id)');
        }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scryfall_products DROP FOREIGN KEY FK_F32CB476A4578F27');
        $this->addSql('DROP TABLE scryfall_products');
       }
}
