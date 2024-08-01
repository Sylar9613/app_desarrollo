<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111215450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accion (id INT AUTO_INCREMENT NOT NULL, tipoaccion_id INT NOT NULL, fecha DATE NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_8A02E3B4C74E4DDC (tipoaccion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE datos (id INT AUTO_INCREMENT NOT NULL, database_filename VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objetivo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(70) NOT NULL, activo TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8F4E816E3A909126 (nombre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objetivo_entidad (id INT AUTO_INCREMENT NOT NULL, entidad_id INT NOT NULL, objetivo_id INT NOT NULL, acciones_id INT NOT NULL, deficiencias LONGTEXT DEFAULT NULL, recomendaciones LONGTEXT DEFAULT NULL, seguimiento LONGTEXT DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_DC2B4E266CA204EF (entidad_id), INDEX IDX_DC2B4E2697F4E608 (objetivo_id), INDEX IDX_DC2B4E26941FF8DD (acciones_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accion ADD CONSTRAINT FK_8A02E3B4C74E4DDC FOREIGN KEY (tipoaccion_id) REFERENCES tipo_accion (id)');
        $this->addSql('ALTER TABLE objetivo_entidad ADD CONSTRAINT FK_DC2B4E266CA204EF FOREIGN KEY (entidad_id) REFERENCES entidad (id)');
        $this->addSql('ALTER TABLE objetivo_entidad ADD CONSTRAINT FK_DC2B4E2697F4E608 FOREIGN KEY (objetivo_id) REFERENCES objetivo (id)');
        $this->addSql('ALTER TABLE objetivo_entidad ADD CONSTRAINT FK_DC2B4E26941FF8DD FOREIGN KEY (acciones_id) REFERENCES accion (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE objetivo_entidad DROP FOREIGN KEY FK_DC2B4E26941FF8DD');
        $this->addSql('ALTER TABLE objetivo_entidad DROP FOREIGN KEY FK_DC2B4E2697F4E608');
        $this->addSql('DROP TABLE accion');
        $this->addSql('DROP TABLE datos');
        $this->addSql('DROP TABLE objetivo');
        $this->addSql('DROP TABLE objetivo_entidad');
    }
}
