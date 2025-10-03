<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250930121740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'modification de la table scryfall pour recuperer d\'autres données plus pertinantes\najout de la table scryfall_expansion\nreduction de la taille des champs montants';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scryfall_expansions (id VARCHAR(36) NOT NULL, code VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, icon_svg_uri VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE logs CHANGE date_import date_import DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE date_import_file date_import_file DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE prices CHANGE avg avg NUMERIC(8, 2) DEFAULT NULL, CHANGE low low NUMERIC(8, 2) DEFAULT NULL, CHANGE trend trend NUMERIC(8, 2) DEFAULT NULL, CHANGE avg1 avg1 NUMERIC(8, 2) DEFAULT NULL, CHANGE avg7 avg7 NUMERIC(8, 2) DEFAULT NULL, CHANGE avg30 avg30 NUMERIC(8, 2) DEFAULT NULL, CHANGE avg_foil avg_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE low_foil low_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE trend_foil trend_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE avg1_foil avg1_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE avg7_foil avg7_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE avg30_foil avg30_foil NUMERIC(8, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE prices_predict CHANGE avg1 avg1 NUMERIC(8, 2) DEFAULT NULL, CHANGE avg1_foil avg1_foil NUMERIC(8, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE scryfall_products ADD scryfall_expansion_id VARCHAR(36) DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, ADD img_normal_uri_back VARCHAR(255) NOT NULL, ADD img_png_uri_back VARCHAR(255) NOT NULL, ADD collector_number VARCHAR(255) NOT NULL, ADD rarity VARCHAR(10) NOT NULL, ADD gatherer_uri VARCHAR(255) NOT NULL, DROP scryfall_uri, DROP img_large_uri, DROP img_artcrop_uri, DROP img_bordercrop_uri');
        $this->addSql('ALTER TABLE scryfall_products ADD CONSTRAINT FK_F32CB476444AA5BD FOREIGN KEY (scryfall_expansion_id) REFERENCES scryfall_expansions (id)');
        $this->addSql('CREATE INDEX IDX_F32CB476444AA5BD ON scryfall_products (scryfall_expansion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scryfall_products DROP FOREIGN KEY FK_F32CB476444AA5BD');
        $this->addSql('DROP TABLE scryfall_expansions');
        $this->addSql('ALTER TABLE logs CHANGE date_import date_import DATETIME DEFAULT \'now()\' NOT NULL, CHANGE date_import_file date_import_file DATETIME DEFAULT \'now()\' NOT NULL');
        $this->addSql('ALTER TABLE prices_predict CHANGE avg1 avg1 NUMERIC(10, 2) DEFAULT NULL, CHANGE avg1_foil avg1_foil NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_F32CB476444AA5BD ON scryfall_products');
        $this->addSql('ALTER TABLE scryfall_products ADD scryfall_uri VARCHAR(255) NOT NULL, ADD img_large_uri VARCHAR(255) NOT NULL, ADD img_artcrop_uri VARCHAR(255) NOT NULL, ADD img_bordercrop_uri VARCHAR(255) NOT NULL, DROP scryfall_expansion_id, DROP name, DROP img_normal_uri_back, DROP img_png_uri_back, DROP collector_number, DROP rarity, DROP gatherer_uri');
        $this->addSql('ALTER TABLE prices CHANGE avg avg NUMERIC(10, 2) DEFAULT NULL, CHANGE low low NUMERIC(10, 2) DEFAULT NULL, CHANGE trend trend NUMERIC(10, 2) DEFAULT NULL, CHANGE avg1 avg1 NUMERIC(10, 2) DEFAULT NULL, CHANGE avg7 avg7 NUMERIC(10, 2) DEFAULT NULL, CHANGE avg30 avg30 NUMERIC(10, 2) DEFAULT NULL, CHANGE avg_foil avg_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE low_foil low_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE trend_foil trend_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE avg1_foil avg1_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE avg7_foil avg7_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE avg30_foil avg30_foil NUMERIC(10, 2) DEFAULT NULL');
    }
}
