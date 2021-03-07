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

        // Add default user
        $this->addSql("INSERT INTO user (id, role_id, first_name, last_name, email, password) VALUES (1, 2, 'John', 'Smith', 'john.smith@example.com', 'password123');");
    }

    public function down(Schema $schema) : void
    {
        // Delete default user
        $this->addSql("DELETE FROM user WHERE id=1;");

        // Delete default roles
        $this->addSql("DELETE FROM role WHERE id=1 OR id=2;");
    }
}
