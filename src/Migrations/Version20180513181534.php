<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180513181534 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note ADD category_id INT NOT NULL, DROP category');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA1412469DE2 ON note (category_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1412469DE2');
        $this->addSql('DROP INDEX IDX_CFBDFA1412469DE2 ON note');
        $this->addSql('ALTER TABLE note ADD category VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, DROP category_id');
    }
}
