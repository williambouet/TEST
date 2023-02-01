<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201100332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist_artist (artist_source INT NOT NULL, artist_target INT NOT NULL, INDEX IDX_F35B9AF9AD88730D (artist_source), INDEX IDX_F35B9AF9B46D2382 (artist_target), PRIMARY KEY(artist_source, artist_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_artist ADD CONSTRAINT FK_F35B9AF9AD88730D FOREIGN KEY (artist_source) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_artist ADD CONSTRAINT FK_F35B9AF9B46D2382 FOREIGN KEY (artist_target) REFERENCES artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_artist DROP FOREIGN KEY FK_F35B9AF9AD88730D');
        $this->addSql('ALTER TABLE artist_artist DROP FOREIGN KEY FK_F35B9AF9B46D2382');
        $this->addSql('DROP TABLE artist_artist');
    }
}
