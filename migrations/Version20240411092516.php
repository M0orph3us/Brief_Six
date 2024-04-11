<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411092516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE responses (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, threads_id INT DEFAULT NULL, body LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_315F9F9467B3B43D (users_id), INDEX IDX_315F9F9483F885A5 (threads_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE threads (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, status VARCHAR(10) NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, body LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_6F8E3DDD67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE threads_categories (threads_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_A72273EE83F885A5 (threads_id), INDEX IDX_A72273EEA21214B7 (categories_id), PRIMARY KEY(threads_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE votes (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, responses_id INT DEFAULT NULL, vote TINYINT(1) NOT NULL, INDEX IDX_518B7ACFA76ED395 (user_id), INDEX IDX_518B7ACF91560F9D (responses_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F9467B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');

        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F9483F885A5 FOREIGN KEY (threads_id) REFERENCES threads (id)');

        $this->addSql('ALTER TABLE threads ADD CONSTRAINT FK_6F8E3DDD67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');

        $this->addSql('ALTER TABLE threads_categories ADD CONSTRAINT FK_A72273EE83F885A5 FOREIGN KEY (threads_id) REFERENCES threads (id) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE threads_categories ADD CONSTRAINT FK_A72273EEA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');

        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF91560F9D FOREIGN KEY (responses_id) REFERENCES responses (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F9467B3B43D');
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F9483F885A5');
        $this->addSql('ALTER TABLE threads DROP FOREIGN KEY FK_6F8E3DDD67B3B43D');
        $this->addSql('ALTER TABLE threads_categories DROP FOREIGN KEY FK_A72273EE83F885A5');
        $this->addSql('ALTER TABLE threads_categories DROP FOREIGN KEY FK_A72273EEA21214B7');
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACFA76ED395');
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACF91560F9D');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE responses');
        $this->addSql('DROP TABLE threads');
        $this->addSql('DROP TABLE threads_categories');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE votes');
    }
}
