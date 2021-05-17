<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210517085440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lecture ADD category_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C167794812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_C167794812469DE2 ON lecture (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C167794812469DE2');
        $this->addSql('DROP INDEX IDX_C167794812469DE2 ON lecture');
        $this->addSql('ALTER TABLE lecture DROP category_id');
    }
}
