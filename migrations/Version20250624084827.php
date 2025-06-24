<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250624084827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream ADD user_id INT NOT NULL, ADD image_name VARCHAR(255) DEFAULT NULL, ADD update_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream ADD CONSTRAINT FK_72A6762BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_72A6762BA76ED395 ON ice_cream (user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream DROP FOREIGN KEY FK_72A6762BA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_72A6762BA76ED395 ON ice_cream
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream DROP user_id, DROP image_name, DROP update_at
        SQL);
    }
}
