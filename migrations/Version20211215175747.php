<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215175747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capital_panthera_trade_updates ADD before_update DOUBLE PRECISION NOT NULL, ADD after_update DOUBLE PRECISION NOT NULL, ADD percentage DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE panthera_trade_income ADD percentage DOUBLE PRECISION NOT NULL, ADD before_update DOUBLE PRECISION NOT NULL, ADD after_update DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capital_panthera_trade_updates DROP before_update, DROP after_update, DROP percentage');
        $this->addSql('ALTER TABLE panthera_trade_income DROP percentage, DROP before_update, DROP after_update');
    }
}
