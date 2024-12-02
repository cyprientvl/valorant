<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202150507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE locker_user_likes (locker_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_70763D96841CF1E0 (locker_id), INDEX IDX_70763D96A76ED395 (user_id), PRIMARY KEY(locker_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE locker_user_likes ADD CONSTRAINT FK_70763D96841CF1E0 FOREIGN KEY (locker_id) REFERENCES locker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locker_user_likes ADD CONSTRAINT FK_70763D96A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locker_user DROP FOREIGN KEY FK_703A75A5841CF1E0');
        $this->addSql('ALTER TABLE locker_user DROP FOREIGN KEY FK_703A75A5A76ED395');
        $this->addSql('DROP TABLE locker_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE locker_user (locker_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_703A75A5A76ED395 (user_id), INDEX IDX_703A75A5841CF1E0 (locker_id), PRIMARY KEY(locker_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE locker_user ADD CONSTRAINT FK_703A75A5841CF1E0 FOREIGN KEY (locker_id) REFERENCES locker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locker_user ADD CONSTRAINT FK_703A75A5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locker_user_likes DROP FOREIGN KEY FK_70763D96841CF1E0');
        $this->addSql('ALTER TABLE locker_user_likes DROP FOREIGN KEY FK_70763D96A76ED395');
        $this->addSql('DROP TABLE locker_user_likes');
    }
}
