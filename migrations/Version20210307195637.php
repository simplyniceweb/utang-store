<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307195637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE debt_item (id INT AUTO_INCREMENT NOT NULL, debt_id INT DEFAULT NULL, amount INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_770BDADA240326A5 (debt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE debt_item ADD CONSTRAINT FK_770BDADA240326A5 FOREIGN KEY (debt_id) REFERENCES debt (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE debt_item');
    }
}
