<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308175233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exchange_status (id INT AUTO_INCREMENT NOT NULL, exchange_id_id INT NOT NULL, status_id_id INT NOT NULL, INDEX IDX_3199BF26173D21F (exchange_id_id), INDEX IDX_3199BF2881ECFA7 (status_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exchange_status ADD CONSTRAINT FK_3199BF26173D21F FOREIGN KEY (exchange_id_id) REFERENCES exchange (id)');
        $this->addSql('ALTER TABLE exchange_status ADD CONSTRAINT FK_3199BF2881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exchange_status DROP FOREIGN KEY FK_3199BF26173D21F');
        $this->addSql('ALTER TABLE exchange_status DROP FOREIGN KEY FK_3199BF2881ECFA7');
        $this->addSql('DROP TABLE exchange_status');
    }
}
