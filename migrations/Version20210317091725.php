<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210317091725 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE debt ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE debt ADD CONSTRAINT FK_DBBF0A83A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_DBBF0A83A76ED395 ON debt (user_id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9240326A5');
        $this->addSql('DROP INDEX IDX_1483A5E9240326A5 ON users');
        $this->addSql('ALTER TABLE users DROP debt_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE debt DROP FOREIGN KEY FK_DBBF0A83A76ED395');
        $this->addSql('DROP INDEX IDX_DBBF0A83A76ED395 ON debt');
        $this->addSql('ALTER TABLE debt DROP user_id');
        $this->addSql('ALTER TABLE users ADD debt_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9240326A5 FOREIGN KEY (debt_id) REFERENCES debt (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9240326A5 ON users (debt_id)');
    }
}
