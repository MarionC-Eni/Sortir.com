<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914150207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_user (event_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_92589AE271F7E88B (event_id), INDEX IDX_92589AE2A76ED395 (user_id), PRIMARY KEY(event_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_user ADD CONSTRAINT FK_92589AE271F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_user ADD CONSTRAINT FK_92589AE2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD locationevent_id INT DEFAULT NULL, ADD eventstate_id INT DEFAULT NULL, ADD eventorgenazedby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7EBFA1A52 FOREIGN KEY (locationevent_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7F4C77413 FOREIGN KEY (eventstate_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7B89211C3 FOREIGN KEY (eventorgenazedby_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7EBFA1A52 ON event (locationevent_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7F4C77413 ON event (eventstate_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7B89211C3 ON event (eventorgenazedby_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_user DROP FOREIGN KEY FK_92589AE271F7E88B');
        $this->addSql('ALTER TABLE event_user DROP FOREIGN KEY FK_92589AE2A76ED395');
        $this->addSql('DROP TABLE event_user');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7EBFA1A52');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7F4C77413');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7B89211C3');
        $this->addSql('DROP INDEX IDX_3BAE0AA7EBFA1A52 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7F4C77413 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7B89211C3 ON event');
        $this->addSql('ALTER TABLE event DROP locationevent_id, DROP eventstate_id, DROP eventorgenazedby_id');
    }
}
