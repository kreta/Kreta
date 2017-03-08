<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kreta\TaskManager\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20161022171904 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE organization (id CHAR(36) NOT NULL COMMENT \'(DC2Type:organization_id)\', name VARCHAR(255) NOT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id CHAR(36) NOT NULL COMMENT \'(DC2Type:organization_member_id)\', organization_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:organization_id)\', created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', INDEX IDX_70E4FA7832C8A3DE (organization_id), UNIQUE INDEX organization_user_index (organization_id, user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id CHAR(36) NOT NULL COMMENT \'(DC2Type:owner_id)\', organization_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:organization_id)\', created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', INDEX IDX_CF60E67C32C8A3DE (organization_id), UNIQUE INDEX organization_user_index (organization_id, user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id CHAR(36) NOT NULL COMMENT \'(DC2Type:project_id)\', created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, organization_id CHAR(36) NOT NULL COMMENT \'(DC2Type:organization_id)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id CHAR(36) NOT NULL COMMENT \'(DC2Type:task_id)\', description VARCHAR(255) NOT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, project_id CHAR(36) NOT NULL COMMENT \'(DC2Type:project_id)\', parent_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:task_id)\', title VARCHAR(255) NOT NULL, priority VARCHAR(100) NOT NULL, progress VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7832C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67C32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7832C8A3DE');
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67C32C8A3DE');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE user');
    }
}
