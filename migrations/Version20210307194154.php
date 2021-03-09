<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210307194154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add default roles and admin user to DB';
    }

    public function up(Schema $schema) : void
    {
        // Add default roles
        $this->addSql("INSERT INTO role (id, name, code) VALUES (1, 'User', 'ROLE_USER');");
        $this->addSql("INSERT INTO role (id, name, code) VALUES (2, 'Administrator', 'ROLE_ADMIN');");

        // Add default user (password: password123)
        $this->addSql("INSERT INTO user (id, role_id, first_name, last_name, email, password) VALUES (1, 2, 'John', 'Smith', 'john.smith@example.com', 'bed4efa1d4fdbd954bd3705d6a2a78270ec9a52ecfbfb010c61862af5c76af1761ffeb1aef6aca1bf5d02b3781aa854fabd2b69c790de74e17ecfec3cb6ac4bf');");
    }

    public function down(Schema $schema) : void
    {
        // Delete default user
        $this->addSql("DELETE FROM user WHERE id=1;");

        // Delete default roles
        $this->addSql("DELETE FROM role WHERE id=1 OR id=2;");
    }

    /*
     * TODO: https://github.com/doctrine/migrations/issues/1104
     */
    public function isTransactional(): bool
    {
        return false;
    }
}
