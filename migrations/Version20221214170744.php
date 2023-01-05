<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214170744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE empresa (id INT AUTO_INCREMENT NOT NULL, razon_social VARCHAR(255) NOT NULL, nombre_fantasia VARCHAR(255) DEFAULT NULL, domicilio VARCHAR(255) DEFAULT NULL, localidad VARCHAR(255) DEFAULT NULL, codigo_postal VARCHAR(255) DEFAULT NULL, cuit VARCHAR(255) DEFAULT NULL, iibb VARCHAR(255) DEFAULT NULL, fecha_inicio_actividades DATE DEFAULT NULL, punto_de_venta INT DEFAULT NULL, passphrase VARCHAR(50) DEFAULT NULL, telefono VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE empresa');
    }
}
