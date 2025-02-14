<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214091617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE soin (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, animal_id INT NOT NULL, description LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_570C0C2A76ED395 (user_id), INDEX IDX_570C0C28E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE soin ADD CONSTRAINT FK_570C0C2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE soin ADD CONSTRAINT FK_570C0C28E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE soin DROP FOREIGN KEY FK_570C0C2A76ED395');
        $this->addSql('ALTER TABLE soin DROP FOREIGN KEY FK_570C0C28E962C16');
        $this->addSql('DROP TABLE soin');
    }
}
