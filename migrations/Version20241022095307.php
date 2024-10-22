<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241022095307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE locker_item (locker_id INT NOT NULL, item_id VARCHAR(255) NOT NULL, INDEX IDX_E2B286F2841CF1E0 (locker_id), INDEX IDX_E2B286F2126F525E (item_id), PRIMARY KEY(locker_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE locker_item ADD CONSTRAINT FK_E2B286F2841CF1E0 FOREIGN KEY (locker_id) REFERENCES locker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locker_item ADD CONSTRAINT FK_E2B286F2126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD locker_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649841CF1E0 FOREIGN KEY (locker_id) REFERENCES locker (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649841CF1E0 ON user (locker_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE locker_item DROP FOREIGN KEY FK_E2B286F2841CF1E0');
        $this->addSql('ALTER TABLE locker_item DROP FOREIGN KEY FK_E2B286F2126F525E');
        $this->addSql('DROP TABLE locker_item');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649841CF1E0');
        $this->addSql('DROP INDEX UNIQ_8D93D649841CF1E0 ON user');
        $this->addSql('ALTER TABLE user DROP locker_id');
    }
}
