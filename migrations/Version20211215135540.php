<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215135540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capital_panthera_trade (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, capital DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_C38DCD5A9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE capital_panthera_trade_updates (id INT AUTO_INCREMENT NOT NULL, capital_id_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_54B7760565CC6A39 (capital_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panthera_trade (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date DATE NOT NULL, capital DOUBLE PRECISION NOT NULL, INDEX IDX_35B908B49D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capital_panthera_trade ADD CONSTRAINT FK_C38DCD5A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE capital_panthera_trade_updates ADD CONSTRAINT FK_54B7760565CC6A39 FOREIGN KEY (capital_id_id) REFERENCES capital_panthera_trade (id)');
        $this->addSql('ALTER TABLE panthera_trade ADD CONSTRAINT FK_35B908B49D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE map ADD CONSTRAINT FK_93ADAABB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tm_stats RENAME INDEX fk_cbe447b3a76ed395 TO IDX_CBE447B3A76ED395');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capital_panthera_trade_updates DROP FOREIGN KEY FK_54B7760565CC6A39');
        $this->addSql('DROP TABLE capital_panthera_trade');
        $this->addSql('DROP TABLE capital_panthera_trade_updates');
        $this->addSql('DROP TABLE panthera_trade');
        $this->addSql('ALTER TABLE map DROP FOREIGN KEY FK_93ADAABB12469DE2');
        $this->addSql('ALTER TABLE tm_stats RENAME INDEX idx_cbe447b3a76ed395 TO FK_CBE447B3A76ED395');
    }
}
