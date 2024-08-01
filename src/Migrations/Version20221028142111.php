<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028142111 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accion_pam (id INT AUTO_INCREMENT NOT NULL, lineas_id INT NOT NULL, nombre LONGTEXT NOT NULL, responsables VARCHAR(255) NOT NULL, fecha VARCHAR(120) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_AFD1503354923972 (lineas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE linea_estrategica (id INT AUTO_INCREMENT NOT NULL, pam_id INT NOT NULL, nombre VARCHAR(120) NOT NULL, indicadores LONGTEXT NOT NULL, activo TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_F764911E3A909126 (nombre), INDEX IDX_F764911E4EFEC163 (pam_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pam (id INT AUTO_INCREMENT NOT NULL, resultados_esperados LONGTEXT NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accion_pam ADD CONSTRAINT FK_AFD1503354923972 FOREIGN KEY (lineas_id) REFERENCES linea_estrategica (id)');
        $this->addSql('ALTER TABLE linea_estrategica ADD CONSTRAINT FK_F764911E4EFEC163 FOREIGN KEY (pam_id) REFERENCES pam (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accion_pam DROP FOREIGN KEY FK_AFD1503354923972');
        $this->addSql('ALTER TABLE linea_estrategica DROP FOREIGN KEY FK_F764911E4EFEC163');
        $this->addSql('DROP TABLE accion_pam');
        $this->addSql('DROP TABLE linea_estrategica');
        $this->addSql('DROP TABLE pam');
    }
}
