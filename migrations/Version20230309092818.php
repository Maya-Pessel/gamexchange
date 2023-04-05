<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309092818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exchange_status DROP FOREIGN KEY FK_3199BF2881ECFA7');
        $this->addSql('ALTER TABLE exchange_status DROP FOREIGN KEY FK_3199BF26173D21F');
        $this->addSql('DROP TABLE exchange_status');
        $this->addSql('ALTER TABLE exchange ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange ADD CONSTRAINT FK_D33BB079B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exchange ADD CONSTRAINT FK_D33BB0796BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_D33BB079B03A8386 ON exchange (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D33BB0796BF700BD ON exchange (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exchange_status (id INT AUTO_INCREMENT NOT NULL, exchange_id_id INT NOT NULL, status_id_id INT NOT NULL, INDEX IDX_3199BF2881ECFA7 (status_id_id), INDEX IDX_3199BF26173D21F (exchange_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE exchange_status ADD CONSTRAINT FK_3199BF2881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE exchange_status ADD CONSTRAINT FK_3199BF26173D21F FOREIGN KEY (exchange_id_id) REFERENCES exchange (id)');
        $this->addSql('ALTER TABLE exchange DROP FOREIGN KEY FK_D33BB079B03A8386');
        $this->addSql('ALTER TABLE exchange DROP FOREIGN KEY FK_D33BB0796BF700BD');
        $this->addSql('DROP INDEX IDX_D33BB079B03A8386 ON exchange');
        $this->addSql('DROP INDEX IDX_D33BB0796BF700BD ON exchange');
        $this->addSql('ALTER TABLE exchange DROP status_id');
    }
}
