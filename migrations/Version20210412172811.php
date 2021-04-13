<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210412172811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tm_stats (map_id INT NOT NULL, user_id INT NOT NULL, record DOUBLE PRECISION NOT NULL, top INT NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CBE447B3A76ED395 (user_id), PRIMARY KEY(map_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tm_stats ADD CONSTRAINT FK_CBE447B353C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('ALTER TABLE tm_stats ADD CONSTRAINT FK_CBE447B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tm_stats');
    }
}
