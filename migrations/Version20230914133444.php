<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914133444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE id_event id_event INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F232F209');
        $this->addSql('DROP INDEX IDX_8D93D649F232F209 ON user');
        $this->addSql('ALTER TABLE user CHANGE schoolsite_id schoolsiteuser_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F819EAC3 FOREIGN KEY (schoolsiteuser_id) REFERENCES campus (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F819EAC3 ON user (schoolsiteuser_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649F819EAC3');
        $this->addSql('DROP INDEX IDX_8D93D649F819EAC3 ON `user`');
        $this->addSql('ALTER TABLE `user` CHANGE schoolsiteuser_id schoolsite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649F232F209 FOREIGN KEY (schoolsite_id) REFERENCES campus (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649F232F209 ON `user` (schoolsite_id)');
        $this->addSql('ALTER TABLE event CHANGE id_event id_event INT NOT NULL');
    }
}
