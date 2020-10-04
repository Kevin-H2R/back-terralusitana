<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004161314 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trophy (id INT AUTO_INCREMENT NOT NULL, wine_id INT DEFAULT NULL, year SMALLINT NOT NULL, name VARCHAR(255) NOT NULL, rank SMALLINT NOT NULL, INDEX IDX_112AFAE928A2BD76 (wine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variety (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, name VARCHAR(255) NOT NULL, alcohol DOUBLE PRECISION NOT NULL, image_path VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(512) NOT NULL, soft SMALLINT DEFAULT NULL, dry SMALLINT DEFAULT NULL, sweet SMALLINT DEFAULT NULL, INDEX IDX_560C646898260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine_variety (wine_id INT NOT NULL, variety_id INT NOT NULL, INDEX IDX_F0F8598228A2BD76 (wine_id), INDEX IDX_F0F8598278C2BC47 (variety_id), PRIMARY KEY(wine_id, variety_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trophy ADD CONSTRAINT FK_112AFAE928A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C646898260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE wine_variety ADD CONSTRAINT FK_F0F8598228A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wine_variety ADD CONSTRAINT FK_F0F8598278C2BC47 FOREIGN KEY (variety_id) REFERENCES variety (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C646898260155');
        $this->addSql('ALTER TABLE wine_variety DROP FOREIGN KEY FK_F0F8598278C2BC47');
        $this->addSql('ALTER TABLE trophy DROP FOREIGN KEY FK_112AFAE928A2BD76');
        $this->addSql('ALTER TABLE wine_variety DROP FOREIGN KEY FK_F0F8598228A2BD76');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE trophy');
        $this->addSql('DROP TABLE variety');
        $this->addSql('DROP TABLE wine');
        $this->addSql('DROP TABLE wine_variety');
    }
}
