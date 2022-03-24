<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222094806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coches ADD marca_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coches ADD CONSTRAINT FK_9A1141DA81EF0041 FOREIGN KEY (marca_id) REFERENCES marcas (id)');
        $this->addSql('CREATE INDEX IDX_9A1141DA81EF0041 ON coches (marca_id)');
        $this->addSql('ALTER TABLE marcas DROP FOREIGN KEY FK_9FB784D4658D2BFA');
        $this->addSql('DROP INDEX IDX_9FB784D4658D2BFA ON marcas');
        $this->addSql('ALTER TABLE marcas DROP coches_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coches DROP FOREIGN KEY FK_9A1141DA81EF0041');
        $this->addSql('DROP INDEX IDX_9A1141DA81EF0041 ON coches');
        $this->addSql('ALTER TABLE coches DROP marca_id, CHANGE modelo modelo VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE descripcion descripcion TEXT DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('ALTER TABLE marcas ADD coches_id INT DEFAULT NULL, CHANGE nombre nombre VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE descripcion descripcion TEXT DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('ALTER TABLE marcas ADD CONSTRAINT FK_9FB784D4658D2BFA FOREIGN KEY (coches_id) REFERENCES coches (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9FB784D4658D2BFA ON marcas (coches_id)');
    }
}
