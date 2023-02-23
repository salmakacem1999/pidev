<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220221555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carnet_cheque ADD idtypecarnet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carnet_cheque ADD CONSTRAINT FK_9CD0911160850051 FOREIGN KEY (idtypecarnet_id) REFERENCES type_carnet (id)');
        $this->addSql('CREATE INDEX IDX_9CD0911160850051 ON carnet_cheque (idtypecarnet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carnet_cheque DROP FOREIGN KEY FK_9CD0911160850051');
        $this->addSql('DROP INDEX IDX_9CD0911160850051 ON carnet_cheque');
        $this->addSql('ALTER TABLE carnet_cheque DROP idtypecarnet_id');
    }
}
