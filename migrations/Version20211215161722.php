<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215161722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capital_panthera_trade ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE capital_panthera_trade ADD CONSTRAINT FK_C38DCD5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C38DCD5AA76ED395 ON capital_panthera_trade (user_id)');
        $this->addSql('ALTER TABLE capital_panthera_trade_updates ADD capital_panthera_trade_id INT NOT NULL');
        $this->addSql('ALTER TABLE capital_panthera_trade_updates ADD CONSTRAINT FK_54B77605EA37380B FOREIGN KEY (capital_panthera_trade_id) REFERENCES capital_panthera_trade (id)');
        $this->addSql('CREATE INDEX IDX_54B77605EA37380B ON capital_panthera_trade_updates (capital_panthera_trade_id)');
        $this->addSql('ALTER TABLE panthera_trade ADD capital_panthera_trade_id INT NOT NULL');
        $this->addSql('ALTER TABLE panthera_trade ADD CONSTRAINT FK_35B908B4EA37380B FOREIGN KEY (capital_panthera_trade_id) REFERENCES capital_panthera_trade (id)');
        $this->addSql('CREATE INDEX IDX_35B908B4EA37380B ON panthera_trade (capital_panthera_trade_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capital_panthera_trade DROP FOREIGN KEY FK_C38DCD5AA76ED395');
        $this->addSql('DROP INDEX UNIQ_C38DCD5AA76ED395 ON capital_panthera_trade');
        $this->addSql('ALTER TABLE capital_panthera_trade DROP user_id');
        $this->addSql('ALTER TABLE capital_panthera_trade_updates DROP FOREIGN KEY FK_54B77605EA37380B');
        $this->addSql('DROP INDEX IDX_54B77605EA37380B ON capital_panthera_trade_updates');
        $this->addSql('ALTER TABLE capital_panthera_trade_updates DROP capital_panthera_trade_id');
        $this->addSql('ALTER TABLE panthera_trade DROP FOREIGN KEY FK_35B908B4EA37380B');
        $this->addSql('DROP INDEX IDX_35B908B4EA37380B ON panthera_trade');
        $this->addSql('ALTER TABLE panthera_trade DROP capital_panthera_trade_id');
    }
}
