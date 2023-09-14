<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914134238 extends AbstractMigration
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
        $this->addSql('ALTER TABLE user CHANGE schoolsite_id mycampus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B3CF85CE FOREIGN KEY (mycampus_id) REFERENCES campus (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B3CF85CE ON user (mycampus_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649B3CF85CE');
        $this->addSql('DROP INDEX IDX_8D93D649B3CF85CE ON `user`');
        $this->addSql('ALTER TABLE `user` CHANGE mycampus_id schoolsite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649F232F209 FOREIGN KEY (schoolsite_id) REFERENCES campus (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649F232F209 ON `user` (schoolsite_id)');
        $this->addSql('ALTER TABLE event CHANGE id_event id_event INT NOT NULL');
    }
}
