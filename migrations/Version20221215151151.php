<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221215151151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exchange (id INT AUTO_INCREMENT NOT NULL, product_id1_id INT NOT NULL, product_id2_id INT NOT NULL, INDEX IDX_D33BB0794160ECFE (product_id1_id), INDEX IDX_D33BB07953D54310 (product_id2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exchange ADD CONSTRAINT FK_D33BB0794160ECFE FOREIGN KEY (product_id1_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE exchange ADD CONSTRAINT FK_D33BB07953D54310 FOREIGN KEY (product_id2_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exchange DROP FOREIGN KEY FK_D33BB0794160ECFE');
        $this->addSql('ALTER TABLE exchange DROP FOREIGN KEY FK_D33BB07953D54310');
        $this->addSql('DROP TABLE exchange');
    }
}
