<?php

namespace Kreta\IdentityAccess\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161101130554 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', created_on DATETIME NOT NULL, last_login DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:user_roles)\', updated_on DATETIME NOT NULL, confirmation_token_token VARCHAR(36) DEFAULT NULL, confirmation_token_created_on DATETIME DEFAULT NULL, email VARCHAR(60) NOT NULL, invitation_token_token VARCHAR(36) DEFAULT NULL, invitation_token_created_on DATETIME DEFAULT NULL, password VARCHAR(60) DEFAULT NULL, salt VARCHAR(60) DEFAULT NULL, remember_password_token_token VARCHAR(36) DEFAULT NULL, remember_password_token_created_on DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
    }
}
