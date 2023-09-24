<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921181653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vehicle ADD COLUMN uuid UUID DEFAULT gen_random_uuid()');
        $this->addSql('ALTER TABLE model ADD COLUMN uuid UUID DEFAULT gen_random_uuid()');
        $this->addSql('ALTER TABLE brand ADD COLUMN uuid UUID DEFAULT gen_random_uuid()');

        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT vehicle_pk2 unique (uuid)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT model_pk2 unique (uuid)');
        $this->addSql('ALTER TABLE brand ADD CONSTRAINT brand_pk2 unique (uuid)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vehicle DROP COLUMN uuid');
        $this->addSql('ALTER TABLE model DROP COLUMN uuid');
        $this->addSql('ALTER TABLE brand DROP COLUMN uuid');

        $this->addSql('ALTER TABLE vehicle DROP CONSTRAINT vehicle_pk2');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT model_pk2');
        $this->addSql('ALTER TABLE brand DROP CONSTRAINT brand_pk2');
    }
}
