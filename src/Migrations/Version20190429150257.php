<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190429150257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE colis ADD poids INT NOT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE date_dep date_dep DATE NOT NULL');
        $this->addSql('ALTER TABLE colis RENAME INDEX idx_470bdff94d268d70 TO IDX_470BDFF9A76ED395');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE colis DROP poids, CHANGE user_id user_id INT NOT NULL, CHANGE date_dep date_dep DATETIME NOT NULL');
        $this->addSql('ALTER TABLE colis RENAME INDEX idx_470bdff9a76ed395 TO IDX_470BDFF94D268D70');
    }
}
