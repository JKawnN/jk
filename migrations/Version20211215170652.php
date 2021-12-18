<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215170652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panthera_trade_income (id INT AUTO_INCREMENT NOT NULL, capital_panthera_trade_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date DATE NOT NULL, capital DOUBLE PRECISION NOT NULL, INDEX IDX_24D00E7BEA37380B (capital_panthera_trade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panthera_trade_income ADD CONSTRAINT FK_24D00E7BEA37380B FOREIGN KEY (capital_panthera_trade_id) REFERENCES capital_panthera_trade (id)');
        $this->addSql('DROP TABLE panthera_trade');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panthera_trade (id INT AUTO_INCREMENT NOT NULL, capital_panthera_trade_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date DATE NOT NULL, capital DOUBLE PRECISION NOT NULL, INDEX IDX_35B908B4EA37380B (capital_panthera_trade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE panthera_trade ADD CONSTRAINT FK_35B908B4EA37380B FOREIGN KEY (capital_panthera_trade_id) REFERENCES capital_panthera_trade (id)');
        $this->addSql('DROP TABLE panthera_trade_income');
    }
}
