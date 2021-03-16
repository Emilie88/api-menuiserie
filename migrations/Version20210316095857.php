<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316095857 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scheduler ADD name LONGTEXT NOT NULL, ADD start DATETIME NOT NULL, ADD end DATETIME NOT NULL, DROP description, DROP end_date, DROP start_date, DROP text');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scheduler ADD description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD end_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD start_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD text VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP name, DROP start, DROP end');
    }
}
