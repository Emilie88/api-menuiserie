<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210405105302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE realisation (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_EAA5610E3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E3DA5256D FOREIGN KEY (image_id) REFERENCES photos (id)');
        $this->addSql('ALTER TABLE scheduler DROP FOREIGN KEY FK_463CEC1879F37AE5');
        $this->addSql('DROP INDEX IDX_463CEC1879F37AE5 ON scheduler');
        $this->addSql('ALTER TABLE scheduler CHANGE color color VARCHAR(255) NOT NULL, CHANGE id_user_id id_us_id INT NOT NULL');
        $this->addSql('ALTER TABLE scheduler ADD CONSTRAINT FK_463CEC18F91FCAC2 FOREIGN KEY (id_us_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_463CEC18F91FCAC2 ON scheduler (id_us_id)');
        $this->addSql('ALTER TABLE user CHANGE last_name last_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE realisation');
        $this->addSql('ALTER TABLE scheduler DROP FOREIGN KEY FK_463CEC18F91FCAC2');
        $this->addSql('DROP INDEX IDX_463CEC18F91FCAC2 ON scheduler');
        $this->addSql('ALTER TABLE scheduler CHANGE color color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE id_us_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE scheduler ADD CONSTRAINT FK_463CEC1879F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_463CEC1879F37AE5 ON scheduler (id_user_id)');
        $this->addSql('ALTER TABLE user CHANGE last_name last_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
