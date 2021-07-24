<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722185324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tb_playgrounds (id INT AUTO_INCREMENT NOT NULL, possition_x DOUBLE PRECISION NOT NULL, possition_y DOUBLE PRECISION NOT NULL, district VARCHAR(30) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tb_reviews (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, playground_id INT NOT NULL, text LONGTEXT NOT NULL, added DATETIME NOT NULL, score INT DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, INDEX IDX_16A731ADA76ED395 (user_id), INDEX IDX_16A731ADF8FE9381 (playground_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tb_users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, login VARCHAR(50) NOT NULL, hash VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tb_reviews ADD CONSTRAINT FK_16A731ADA76ED395 FOREIGN KEY (user_id) REFERENCES tb_users (id)');
        $this->addSql('ALTER TABLE tb_reviews ADD CONSTRAINT FK_16A731ADF8FE9381 FOREIGN KEY (playground_id) REFERENCES tb_playgrounds (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tb_reviews DROP FOREIGN KEY FK_16A731ADF8FE9381');
        $this->addSql('ALTER TABLE tb_reviews DROP FOREIGN KEY FK_16A731ADA76ED395');
        $this->addSql('DROP TABLE tb_playgrounds');
        $this->addSql('DROP TABLE tb_reviews');
        $this->addSql('DROP TABLE tb_users');
    }
}
