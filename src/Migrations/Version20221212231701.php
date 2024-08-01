<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212231701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accion_pam DROP FOREIGN KEY FK_AFD1503385FE79F8');
        $this->addSql('ALTER TABLE accion_pam ADD CONSTRAINT FK_AFD1503385FE79F8 FOREIGN KEY (linea_id) REFERENCES linea_estrategica (id)');
        $this->addSql('ALTER TABLE linea_estrategica CHANGE pam_id pam_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pam ADD nombre VARCHAR(150) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accion_pam DROP FOREIGN KEY FK_AFD1503385FE79F8');
        $this->addSql('ALTER TABLE accion_pam ADD CONSTRAINT FK_AFD1503385FE79F8 FOREIGN KEY (linea_id) REFERENCES pam (id)');
        $this->addSql('ALTER TABLE linea_estrategica CHANGE pam_id pam_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pam DROP nombre');
    }
}
