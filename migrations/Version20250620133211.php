<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250620133211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE ice_cream_toping (ice_cream_id INT NOT NULL, toping_id INT NOT NULL, INDEX IDX_E9218A111489B4EE (ice_cream_id), INDEX IDX_E9218A1198EDA06D (toping_id), PRIMARY KEY(ice_cream_id, toping_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE toping (id INT AUTO_INCREMENT NOT NULL, type_toping VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream_toping ADD CONSTRAINT FK_E9218A111489B4EE FOREIGN KEY (ice_cream_id) REFERENCES ice_cream (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream_toping ADD CONSTRAINT FK_E9218A1198EDA06D FOREIGN KEY (toping_id) REFERENCES toping (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream CHANGE special_ingredient special_ingredient VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream_toping DROP FOREIGN KEY FK_E9218A111489B4EE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream_toping DROP FOREIGN KEY FK_E9218A1198EDA06D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ice_cream_toping
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE toping
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ice_cream CHANGE special_ingredient special_ingredient VARCHAR(255) DEFAULT NULL
        SQL);
    }
}
