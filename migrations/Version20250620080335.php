<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250620080335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE cone (id INT AUTO_INCREMENT NOT NULL, type_cone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream ADD cone_id INT DEFAULT NULL, ADD special_ingredient VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream ADD CONSTRAINT FK_72A6762B6D6AE6B6 FOREIGN KEY (cone_id) REFERENCES cone (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_72A6762B6D6AE6B6 ON ice_cream (cone_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream DROP FOREIGN KEY FK_72A6762B6D6AE6B6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cone
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_72A6762B6D6AE6B6 ON ice_cream
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream DROP cone_id, DROP special_ingredient
        SQL);
    }
}
