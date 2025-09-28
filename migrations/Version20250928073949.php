<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250928073949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change numeric fields precision';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prices CHANGE avg avg NUMERIC(8, 2) DEFAULT NULL, CHANGE low low NUMERIC(8, 2) DEFAULT NULL, CHANGE trend trend NUMERIC(8, 2) DEFAULT NULL, CHANGE avg1 avg1 NUMERIC(8, 2) DEFAULT NULL, CHANGE avg7 avg7 NUMERIC(8, 2) DEFAULT NULL, CHANGE avg30 avg30 NUMERIC(8, 2) DEFAULT NULL, CHANGE avg_foil avg_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE low_foil low_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE trend_foil trend_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE avg1_foil avg1_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE avg7_foil avg7_foil NUMERIC(8, 2) DEFAULT NULL, CHANGE avg30_foil avg30_foil NUMERIC(8, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE prices_predict CHANGE avg1 avg1 NUMERIC(8, 2) DEFAULT NULL, CHANGE avg1_foil avg1_foil NUMERIC(8, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prices_predict CHANGE avg1 avg1 NUMERIC(10, 2) DEFAULT NULL, CHANGE avg1_foil avg1_foil NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE prices CHANGE avg avg NUMERIC(10, 2) DEFAULT NULL, CHANGE low low NUMERIC(10, 2) DEFAULT NULL, CHANGE trend trend NUMERIC(10, 2) DEFAULT NULL, CHANGE avg1 avg1 NUMERIC(10, 2) DEFAULT NULL, CHANGE avg7 avg7 NUMERIC(10, 2) DEFAULT NULL, CHANGE avg30 avg30 NUMERIC(10, 2) DEFAULT NULL, CHANGE avg_foil avg_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE low_foil low_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE trend_foil trend_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE avg1_foil avg1_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE avg7_foil avg7_foil NUMERIC(10, 2) DEFAULT NULL, CHANGE avg30_foil avg30_foil NUMERIC(10, 2) DEFAULT NULL');
    }
}
