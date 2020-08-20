<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200820133340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE address');
        $this->addSql('ALTER TABLE student ADD teacher_id INT NOT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD address_street VARCHAR(255) NOT NULL, ADD address_street_number VARCHAR(255) NOT NULL, ADD address_city VARCHAR(255) NOT NULL, ADD address_zipcode VARCHAR(255) NOT NULL, DROP firstname, DROP lastname, DROP address, DROP teacher');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF3341807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_B723AF3341807E1D ON student (teacher_id)');
        $this->addSql('ALTER TABLE teacher ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD students VARCHAR(255) NOT NULL, ADD address_street VARCHAR(255) NOT NULL, ADD address_street_number VARCHAR(255) NOT NULL, ADD address_city VARCHAR(255) NOT NULL, ADD address_zipcode VARCHAR(255) NOT NULL, DROP name, DROP address');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, streetnumber INT NOT NULL, city VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, zipcode INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF3341807E1D');
        $this->addSql('DROP INDEX IDX_B723AF3341807E1D ON student');
        $this->addSql('ALTER TABLE student ADD firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD teacher VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP teacher_id, DROP first_name, DROP last_name, DROP address_street, DROP address_street_number, DROP address_city, DROP address_zipcode');
        $this->addSql('ALTER TABLE teacher ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP first_name, DROP last_name, DROP students, DROP address_street, DROP address_street_number, DROP address_city, DROP address_zipcode');
    }
}
