<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514164311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campervan (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, registration_number VARCHAR(255) NOT NULL, is_rented_out TINYINT(1) NOT NULL, INDEX IDX_6891BB7FC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campervan_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT NOT NULL, max_order_quantity INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, pickup_station_id INT NOT NULL, return_station_id INT NOT NULL, user_id INT NOT NULL, campervan_id INT NOT NULL, functional_id VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_F529939873279A0B (pickup_station_id), INDEX IDX_F5299398EA291807 (return_station_id), INDEX IDX_F5299398A76ED395 (user_id), INDEX IDX_F5299398B9D53E94 (campervan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_equipment (id INT AUTO_INCREMENT NOT NULL, rent_id INT NOT NULL, equipment_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_6FBFAE7BE5FD6250 (rent_id), INDEX IDX_6FBFAE7B517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station_equipment (id INT AUTO_INCREMENT NOT NULL, station_id INT NOT NULL, equipment_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_51BCBB9821BDB235 (station_id), INDEX IDX_51BCBB98517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, fullname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campervan ADD CONSTRAINT FK_6891BB7FC54C8C93 FOREIGN KEY (type_id) REFERENCES campervan_type (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939873279A0B FOREIGN KEY (pickup_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398EA291807 FOREIGN KEY (return_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B9D53E94 FOREIGN KEY (campervan_id) REFERENCES campervan (id)');
        $this->addSql('ALTER TABLE order_equipment ADD CONSTRAINT FK_6FBFAE7BE5FD6250 FOREIGN KEY (rent_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_equipment ADD CONSTRAINT FK_6FBFAE7B517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
        $this->addSql('ALTER TABLE station_equipment ADD CONSTRAINT FK_51BCBB9821BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE station_equipment ADD CONSTRAINT FK_51BCBB98517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B9D53E94');
        $this->addSql('ALTER TABLE campervan DROP FOREIGN KEY FK_6891BB7FC54C8C93');
        $this->addSql('ALTER TABLE order_equipment DROP FOREIGN KEY FK_6FBFAE7B517FE9FE');
        $this->addSql('ALTER TABLE station_equipment DROP FOREIGN KEY FK_51BCBB98517FE9FE');
        $this->addSql('ALTER TABLE order_equipment DROP FOREIGN KEY FK_6FBFAE7BE5FD6250');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939873279A0B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398EA291807');
        $this->addSql('ALTER TABLE station_equipment DROP FOREIGN KEY FK_51BCBB9821BDB235');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP TABLE campervan');
        $this->addSql('DROP TABLE campervan_type');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_equipment');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE station_equipment');
        $this->addSql('DROP TABLE user');
    }
}
