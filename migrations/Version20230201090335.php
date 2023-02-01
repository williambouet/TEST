<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201090335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist_artwork (artist_id INT NOT NULL, artwork_id INT NOT NULL, INDEX IDX_3F509B41B7970CF8 (artist_id), INDEX IDX_3F509B41DB8FFA4 (artwork_id), PRIMARY KEY(artist_id, artwork_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_artwork ADD CONSTRAINT FK_3F509B41B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_artwork ADD CONSTRAINT FK_3F509B41DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_artwork DROP FOREIGN KEY FK_3F509B41B7970CF8');
        $this->addSql('ALTER TABLE artist_artwork DROP FOREIGN KEY FK_3F509B41DB8FFA4');
        $this->addSql('DROP TABLE artist_artwork');
    }
}
