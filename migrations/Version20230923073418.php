<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230923073418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO public.brand (id, brand_name, uuid) VALUES (1, 'PEUGOT', '76ab9a02-f113-48d6-b581-2a8431132eca')");
        $this->addSql("INSERT INTO public.brand (id, brand_name, uuid) VALUES (2, 'MERCEDES', 'bf28cf6a-83e5-4c56-ba24-8eb3e32a16f8')");
        $this->addSql("INSERT INTO public.brand (id, brand_name, uuid) VALUES (3, 'SCANIA', 'fd1b095b-28ca-4ab3-b144-169b68e71fa1')");

        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (2, 1, '5008', 'f30b7e69-fc19-4f67-a840-022a88cdb690')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (1, 1, '308', 'f4444367-dcbf-4ff5-b0ae-0ccb3353da00')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (4, 1, '104', 'bedab66c-7613-4673-925d-63f6e53926a1')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (5, 1, '106', '0a17de2f-022c-4fba-9329-a540ac895fa7')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (6, 1, '107', 'aeb40003-8cea-4e26-a7c6-abfc104ddced')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (7, 1, '108', 'c3477d2d-9c44-40cb-8e8c-35a757b5ae69')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (8, 2, 'Vito', '9f8a99d6-ccfe-4592-a21b-37590ff7b878')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (9, 2, 'Viano', '5635cc67-f229-4d83-a2ee-6e2246800601')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (10, 2, 'W123', 'b7042f07-6ff8-4a66-a203-99b01c704242')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (11, 3, 'R380', '756bdcbe-45ce-4653-add4-069197367d83')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (12, 3, 'R420', '7dc69ae4-d515-4ac1-b743-f9edcea3fcf3')");
        $this->addSql("INSERT INTO public.model (id, brand_id, model_name, uuid) VALUES (13, 3, 'R450', 'e515e5f2-5692-400c-a02f-5bc32545bf4d')");



    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
