<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222091052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coches DROP FOREIGN KEY coches_ibfk_1');
        $this->addSql('DROP INDEX marca ON coches');
        $this->addSql('ALTER TABLE coches DROP marca');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coches ADD marca INT DEFAULT NULL, CHANGE modelo modelo VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE descripcion descripcion TEXT DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('ALTER TABLE coches ADD CONSTRAINT coches_ibfk_1 FOREIGN KEY (marca) REFERENCES marcas (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX marca ON coches (marca)');
        $this->addSql('ALTER TABLE marcas CHANGE nombre nombre VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE descripcion descripcion TEXT DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`');
    }
}
