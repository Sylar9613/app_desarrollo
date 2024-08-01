<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212020115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accion_pam DROP FOREIGN KEY FK_AFD1503354923972');
        $this->addSql('DROP INDEX IDX_AFD1503354923972 ON accion_pam');
        $this->addSql('ALTER TABLE accion_pam DROP lineas_id');
        $this->addSql('ALTER TABLE linea_estrategica ADD accion_id INT NOT NULL');
        $this->addSql('ALTER TABLE linea_estrategica ADD CONSTRAINT FK_F764911E3F4B5275 FOREIGN KEY (accion_id) REFERENCES pam (id)');
        $this->addSql('CREATE INDEX IDX_F764911E3F4B5275 ON linea_estrategica (accion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accion_pam ADD lineas_id INT NOT NULL');
        $this->addSql('ALTER TABLE accion_pam ADD CONSTRAINT FK_AFD1503354923972 FOREIGN KEY (lineas_id) REFERENCES linea_estrategica (id)');
        $this->addSql('CREATE INDEX IDX_AFD1503354923972 ON accion_pam (lineas_id)');
        $this->addSql('ALTER TABLE linea_estrategica DROP FOREIGN KEY FK_F764911E3F4B5275');
        $this->addSql('DROP INDEX IDX_F764911E3F4B5275 ON linea_estrategica');
        $this->addSql('ALTER TABLE linea_estrategica DROP accion_id');
    }
}
