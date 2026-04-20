<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260420082353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP item_id');
        $this->addSql('ALTER TABLE offer ADD item_id INT NOT NULL, CHANGE amount amount INT NOT NULL');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_29D6873E126F525E ON offer (item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item ADD item_id INT NOT NULL');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E126F525E');
        $this->addSql('DROP INDEX IDX_29D6873E126F525E ON offer');
        $this->addSql('ALTER TABLE offer DROP item_id, CHANGE amount amount DOUBLE PRECISION NOT NULL');
    }
}
