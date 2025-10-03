<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251002155544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ajout table expansions_matching pour lier expansions cardmarket et scryfall';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expansions_matching (id INT AUTO_INCREMENT NOT NULL, cardMarketExpansionId INT DEFAULT NULL, scryfallExpansionId VARCHAR(36) DEFAULT NULL, INDEX IDX_434CFEED542194EC (cardMarketExpansionId), INDEX IDX_434CFEED5059BB7B (scryfallExpansionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expansions_matching ADD CONSTRAINT FK_434CFEED542194EC FOREIGN KEY (cardMarketExpansionId) REFERENCES expansions (id)');
        $this->addSql('ALTER TABLE expansions_matching ADD CONSTRAINT FK_434CFEED5059BB7B FOREIGN KEY (scryfallExpansionId) REFERENCES scryfall_expansions (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansions_matching DROP FOREIGN KEY FK_434CFEED542194EC');
        $this->addSql('ALTER TABLE expansions_matching DROP FOREIGN KEY FK_434CFEED5059BB7B');
        $this->addSql('DROP TABLE expansions_matching');
    }
}
