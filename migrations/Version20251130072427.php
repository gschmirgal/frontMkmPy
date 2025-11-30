<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251130072427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add performance indexes for prices table - date_data and composite indexes for ranking queries';
    }

    public function up(Schema $schema): void
    {
        // Index on date_data for filtering by date
        $this->addSql('CREATE INDEX idx_prices_date_data ON prices (date_data)');

        // Composite index for (idProduct, date_data) for joining historical prices
        $this->addSql('CREATE INDEX idx_prices_product_date ON prices (idProduct, date_data)');

        // Composite indexes for (date_data, idProduct) for latest prices lookup
        $this->addSql('CREATE INDEX idx_prices_date_product ON prices (date_data, idProduct)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX idx_prices_date_data ON prices');
        $this->addSql('DROP INDEX idx_prices_product_date ON prices');
        $this->addSql('DROP INDEX idx_prices_date_product ON prices');
    }
}
