<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240410141028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE threads_categories (threads_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_A72273EE83F885A5 (threads_id), INDEX IDX_A72273EEA21214B7 (categories_id), PRIMARY KEY(threads_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE threads_categories ADD CONSTRAINT FK_A72273EE83F885A5 FOREIGN KEY (threads_id) REFERENCES threads (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE threads_categories ADD CONSTRAINT FK_A72273EEA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE votes');
        $this->addSql('ALTER TABLE responses ADD user_id_id INT NOT NULL, ADD thread_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F949D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F9475C0816C FOREIGN KEY (thread_id_id) REFERENCES threads (id)');
        $this->addSql('CREATE INDEX IDX_315F9F949D86650F ON responses (user_id_id)');
        $this->addSql('CREATE INDEX IDX_315F9F9475C0816C ON responses (thread_id_id)');
        $this->addSql('ALTER TABLE threads ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE threads ADD CONSTRAINT FK_6F8E3DDD9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_6F8E3DDD9D86650F ON threads (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE votes (id INT AUTO_INCREMENT NOT NULL, vote TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE threads_categories DROP FOREIGN KEY FK_A72273EE83F885A5');
        $this->addSql('ALTER TABLE threads_categories DROP FOREIGN KEY FK_A72273EEA21214B7');
        $this->addSql('DROP TABLE threads_categories');
        $this->addSql('ALTER TABLE threads DROP FOREIGN KEY FK_6F8E3DDD9D86650F');
        $this->addSql('DROP INDEX IDX_6F8E3DDD9D86650F ON threads');
        $this->addSql('ALTER TABLE threads DROP user_id_id');
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F949D86650F');
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F9475C0816C');
        $this->addSql('DROP INDEX IDX_315F9F949D86650F ON responses');
        $this->addSql('DROP INDEX IDX_315F9F9475C0816C ON responses');
        $this->addSql('ALTER TABLE responses DROP user_id_id, DROP thread_id_id');
    }
}
