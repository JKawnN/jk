<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210405114850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, world_record TIME DEFAULT NULL, category VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, riot_pseudo VARCHAR(255) DEFAULT NULL, riot_puuid VARCHAR(255) DEFAULT NULL, riot_account_id VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tm_stats (id INT AUTO_INCREMENT NOT NULL, map_id INT NOT NULL, player_id INT NOT NULL, record TIME NOT NULL, top INT NOT NULL, INDEX IDX_CBE447B353C55F64 (map_id), INDEX IDX_CBE447B399E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tm_stats ADD CONSTRAINT FK_CBE447B353C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('ALTER TABLE tm_stats ADD CONSTRAINT FK_CBE447B399E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tm_stats DROP FOREIGN KEY FK_CBE447B353C55F64');
        $this->addSql('ALTER TABLE tm_stats DROP FOREIGN KEY FK_CBE447B399E6F5DF');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE tm_stats');
    }
}
