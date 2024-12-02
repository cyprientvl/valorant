<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202084546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chroma (id VARCHAR(191) NOT NULL, item_id VARCHAR(191) NOT NULL, display_name VARCHAR(191) NOT NULL, display_icon VARCHAR(191) NOT NULL, INDEX IDX_FEBB40F5126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id VARCHAR(191) NOT NULL, display_name VARCHAR(191) NOT NULL, item_type VARCHAR(191) NOT NULL, display_icon VARCHAR(191) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locker (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(191) NOT NULL, is_public TINYINT(1) NOT NULL, likes INT NOT NULL, UNIQUE INDEX UNIQ_1E067DC0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locker_user_likes (locker_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_70763D96841CF1E0 (locker_id), INDEX IDX_70763D96A76ED395 (user_id), PRIMARY KEY(locker_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locker_item (id INT AUTO_INCREMENT NOT NULL, locker_id INT NOT NULL, item_id VARCHAR(191) NOT NULL, chroma_id VARCHAR(191) DEFAULT NULL, is_main_item_type TINYINT(1) NOT NULL, INDEX IDX_E2B286F2841CF1E0 (locker_id), INDEX IDX_E2B286F2126F525E (item_id), INDEX IDX_E2B286F2798451F4 (chroma_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chroma ADD CONSTRAINT FK_FEBB40F5126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE locker ADD CONSTRAINT FK_1E067DC0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE locker_user_likes ADD CONSTRAINT FK_70763D96841CF1E0 FOREIGN KEY (locker_id) REFERENCES locker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locker_user_likes ADD CONSTRAINT FK_70763D96A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locker_item ADD CONSTRAINT FK_E2B286F2841CF1E0 FOREIGN KEY (locker_id) REFERENCES locker (id)');
        $this->addSql('ALTER TABLE locker_item ADD CONSTRAINT FK_E2B286F2126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE locker_item ADD CONSTRAINT FK_E2B286F2798451F4 FOREIGN KEY (chroma_id) REFERENCES chroma (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chroma DROP FOREIGN KEY FK_FEBB40F5126F525E');
        $this->addSql('ALTER TABLE locker DROP FOREIGN KEY FK_1E067DC0A76ED395');
        $this->addSql('ALTER TABLE locker_user_likes DROP FOREIGN KEY FK_70763D96841CF1E0');
        $this->addSql('ALTER TABLE locker_user_likes DROP FOREIGN KEY FK_70763D96A76ED395');
        $this->addSql('ALTER TABLE locker_item DROP FOREIGN KEY FK_E2B286F2841CF1E0');
        $this->addSql('ALTER TABLE locker_item DROP FOREIGN KEY FK_E2B286F2126F525E');
        $this->addSql('ALTER TABLE locker_item DROP FOREIGN KEY FK_E2B286F2798451F4');
        $this->addSql('DROP TABLE chroma');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE locker');
        $this->addSql('DROP TABLE locker_user_likes');
        $this->addSql('DROP TABLE locker_item');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
