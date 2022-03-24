<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222101335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coches ADD propietario VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coches DROP propietario, CHANGE modelo modelo VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE descripcion descripcion TEXT DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('ALTER TABLE marcas CHANGE nombre nombre VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE descripcion descripcion TEXT DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`');
    }
}
