<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326093259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, name_image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment CHANGE rating rating VARCHAR(1) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526C79F37AE5 ON comment (id_user_id)');
        $this->addSql('ALTER TABLE realisation ADD image_id INT NOT NULL, DROP image_name');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E3DA5256D FOREIGN KEY (image_id) REFERENCES photos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EAA5610E3DA5256D ON realisation (image_id)');
        $this->addSql('ALTER TABLE scheduler CHANGE color color VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE last_name last_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610E3DA5256D');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE photos');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C79F37AE5');
        $this->addSql('DROP INDEX IDX_9474526C79F37AE5 ON comment');
        $this->addSql('ALTER TABLE comment CHANGE rating rating VARCHAR(6) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_EAA5610E3DA5256D ON realisation');
        $this->addSql('ALTER TABLE realisation ADD image_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP image_id');
        $this->addSql('ALTER TABLE scheduler CHANGE color color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE last_name last_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
