<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210321200314 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE debt_payment (debt_id INT NOT NULL, payment_id INT NOT NULL, INDEX IDX_751D57EF240326A5 (debt_id), INDEX IDX_751D57EF4C3A3BB (payment_id), PRIMARY KEY(debt_id, payment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, balance DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE debt_payment ADD CONSTRAINT FK_751D57EF240326A5 FOREIGN KEY (debt_id) REFERENCES debt (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE debt_payment ADD CONSTRAINT FK_751D57EF4C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE debt_payment DROP FOREIGN KEY FK_751D57EF4C3A3BB');
        $this->addSql('DROP TABLE debt_payment');
        $this->addSql('DROP TABLE payment');
    }
}
