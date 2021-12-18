<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215165537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capital_panthera_trade DROP FOREIGN KEY FK_C38DCD5A9D86650F');
        $this->addSql('DROP INDEX UNIQ_C38DCD5A9D86650F ON capital_panthera_trade');
        $this->addSql('ALTER TABLE capital_panthera_trade DROP user_id_id');
        $this->addSql('ALTER TABLE capital_panthera_trade_updates DROP FOREIGN KEY FK_54B7760565CC6A39');
        $this->addSql('DROP INDEX IDX_54B7760565CC6A39 ON capital_panthera_trade_updates');
        $this->addSql('ALTER TABLE capital_panthera_trade_updates DROP capital_id_id');
        $this->addSql('ALTER TABLE panthera_trade DROP FOREIGN KEY FK_35B908B49D86650F');
        $this->addSql('DROP INDEX IDX_35B908B49D86650F ON panthera_trade');
        $this->addSql('ALTER TABLE panthera_trade DROP user_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capital_panthera_trade ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE capital_panthera_trade ADD CONSTRAINT FK_C38DCD5A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C38DCD5A9D86650F ON capital_panthera_trade (user_id_id)');
        $this->addSql('ALTER TABLE capital_panthera_trade_updates ADD capital_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE capital_panthera_trade_updates ADD CONSTRAINT FK_54B7760565CC6A39 FOREIGN KEY (capital_id_id) REFERENCES capital_panthera_trade (id)');
        $this->addSql('CREATE INDEX IDX_54B7760565CC6A39 ON capital_panthera_trade_updates (capital_id_id)');
        $this->addSql('ALTER TABLE panthera_trade ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE panthera_trade ADD CONSTRAINT FK_35B908B49D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_35B908B49D86650F ON panthera_trade (user_id_id)');
    }
}
