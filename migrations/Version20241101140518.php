<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101140518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chroma DROP FOREIGN KEY FK_FEBB40F5126F525E');
        $this->addSql('ALTER TABLE chroma ADD CONSTRAINT FK_FEBB40F5126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chroma DROP FOREIGN KEY FK_FEBB40F5126F525E');
        $this->addSql('ALTER TABLE chroma ADD CONSTRAINT FK_FEBB40F5126F525E FOREIGN KEY (item_id) REFERENCES chroma (id)');
    }
}
