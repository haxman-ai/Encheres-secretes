<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260417130922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_item (category_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_94805F5912469DE2 (category_id), INDEX IDX_94805F59126F525E (item_id), PRIMARY KEY (category_id, item_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE category_item ADD CONSTRAINT FK_94805F5912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_item ADD CONSTRAINT FK_94805F59126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_item DROP FOREIGN KEY FK_94805F5912469DE2');
        $this->addSql('ALTER TABLE category_item DROP FOREIGN KEY FK_94805F59126F525E');
        $this->addSql('DROP TABLE category_item');
    }
}
