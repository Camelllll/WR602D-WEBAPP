<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417094811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pdf ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE pdf ADD CONSTRAINT FK_EF0DB8CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_EF0DB8CA76ED395 ON pdf (user_id)');
        $this->addSql('ALTER TABLE subscription ADD pdf_limit INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pdf DROP FOREIGN KEY FK_EF0DB8CA76ED395');
        $this->addSql('DROP INDEX IDX_EF0DB8CA76ED395 ON pdf');
        $this->addSql('ALTER TABLE pdf DROP user_id');
        $this->addSql('ALTER TABLE subscription DROP pdf_limit');
    }
}
