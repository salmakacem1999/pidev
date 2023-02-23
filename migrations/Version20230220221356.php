<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220221356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_carnet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, startnum VARCHAR(255) NOT NULL, endnum VARCHAR(255) NOT NULL, datecreation DATE NOT NULL, datevalidation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carnet_cheque ADD email VARCHAR(255) NOT NULL, ADD identifier VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD cin_s1 VARCHAR(255) NOT NULL, ADD cin_s2 VARCHAR(255) NOT NULL, ADD document VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE type_carnet');
        $this->addSql('ALTER TABLE carnet_cheque DROP email, DROP identifier, DROP description, DROP cin_s1, DROP cin_s2, DROP document');
    }
}
