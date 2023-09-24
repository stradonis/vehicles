<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919105029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vehicle_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE brand (id SERIAL, brand_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN brand.brand_name IS \'(DC2Type:brand_name)\'');
        $this->addSql('CREATE TABLE model (id SERIAL, brand_id INT NOT NULL, model_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D79572D944F5D008 ON model (brand_id)');
        $this->addSql('COMMENT ON COLUMN model.model_name IS \'(DC2Type:model_name)\'');
        $this->addSql('CREATE TABLE vehicle (id SERIAL, model_id INT NOT NULL, registration_number VARCHAR(255) NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modification_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B80E4867975B7E7 ON vehicle (registration_number)');
        $this->addSql('COMMENT ON COLUMN vehicle.registration_number IS \'(DC2Type:registration_number)\'');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4867975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vehicle_id_seq CASCADE');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE vehicle DROP CONSTRAINT FK_1B80E4867975B7E7');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE vehicle');
    }
}
