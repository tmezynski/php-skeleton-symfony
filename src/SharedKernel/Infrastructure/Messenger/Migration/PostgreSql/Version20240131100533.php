<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Migration\PostgreSql;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240131100533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates outbox table';
    }

    public function up(Schema $schema): void //phpcs:ignore
    {
        $this->createOutboxTables();
        $this->createInboxTables();
    }

    public function down(Schema $schema): void //phpcs:ignore
    {
        $this->addSql('DROP TABLE IF EXISTS _outbox;');
        $this->addSql('DROP TABLE IF EXISTS _outbox_failed;');
        $this->addSql('DROP TABLE IF EXISTS _outbox_log;');
        $this->addSql('DROP TABLE IF EXISTS _inbox;');
        $this->addSql('DROP TABLE IF EXISTS _inbox_failed;');
        $this->addSql('DROP TABLE IF EXISTS _inbox_log;');
    }

    public function createOutboxTables(): void
    {
        $this->addSql(
            <<<SQL
            CREATE TABLE IF NOT EXISTS _outbox (
              id bigserial primary key,
              body text NOT NULL,
              headers text NOT NULL,
              queue_name character varying(190) NOT NULL,
              created_at timestamp NOT NULL,
              available_at timestamp NOT NULL,
              delivered_at timestamp DEFAULT NULL
            )
        SQL
        );

        $this->addSql('CREATE INDEX outbox_queue_name_idx ON _outbox USING btree (queue_name);');
        $this->addSql('CREATE INDEX outbox_available_at_idx ON _outbox USING btree (available_at);');
        $this->addSql('CREATE INDEX outbox_delivered_at_idx ON _outbox USING btree (delivered_at);');

        $this->addSql(
            <<<SQL
            CREATE TABLE IF NOT EXISTS _outbox_failed (
              id bigserial primary key,
              body text NOT NULL,
              headers text NOT NULL,
              queue_name character varying(190) NOT NULL,
              created_at timestamp NOT NULL,
              available_at timestamp NOT NULL,
              delivered_at timestamp DEFAULT NULL
            )
        SQL
        );

        $this->addSql('CREATE INDEX outbox_failed_queue_name_idx ON _outbox_failed USING btree (queue_name);');
        $this->addSql('CREATE INDEX outbox_failed_available_at_idx ON _outbox_failed USING btree (available_at);');
        $this->addSql('CREATE INDEX outbox_failed_delivered_at_idx ON _outbox_failed USING btree (delivered_at);');

        $this->addSql(
            <<<SQL
            CREATE TABLE IF NOT EXISTS _outbox_log (
              id bigserial primary key,
              body text NOT NULL,
              headers text NOT NULL,
              queue_name character varying(190) NOT NULL,
              created_at timestamp NOT NULL,
              available_at timestamp NOT NULL,
              delivered_at timestamp DEFAULT NULL
            )
        SQL
        );
    }

    private function createInboxTables(): void
    {
        $this->addSql(
            <<<SQL
            CREATE TABLE IF NOT EXISTS _inbox (
              id bigserial primary key,
              body text NOT NULL,
              headers text NOT NULL,
              queue_name character varying(190) NOT NULL,
              created_at timestamp NOT NULL,
              available_at timestamp NOT NULL,
              delivered_at timestamp DEFAULT NULL
            )
        SQL
        );

        $this->addSql('CREATE INDEX inbox_queue_name_idx ON _inbox USING btree (queue_name);');
        $this->addSql('CREATE INDEX inbox_available_at_idx ON _inbox USING btree (available_at);');
        $this->addSql('CREATE INDEX inbox_delivered_at_idx ON _inbox USING btree (delivered_at);');

        $this->addSql(
            <<<SQL
            CREATE TABLE IF NOT EXISTS _inbox_failed (
              id bigserial primary key,
              body text NOT NULL,
              headers text NOT NULL,
              queue_name character varying(190) NOT NULL,
              created_at timestamp NOT NULL,
              available_at timestamp NOT NULL,
              delivered_at timestamp DEFAULT NULL
            )
        SQL
        );

        $this->addSql('CREATE INDEX inbox_failed_queue_name_idx ON _inbox_failed USING btree (queue_name);');
        $this->addSql('CREATE INDEX inbox_failed_available_at_idx ON _inbox_failed USING btree (available_at);');
        $this->addSql('CREATE INDEX inbox_failed_delivered_at_idx ON _inbox_failed USING btree (delivered_at);');

        $this->addSql(
            <<<SQL
            CREATE TABLE IF NOT EXISTS _inbox_log (
              id bigserial primary key,
              body text NOT NULL,
              headers text NOT NULL,
              queue_name character varying(190) NOT NULL,
              created_at timestamp NOT NULL,
              available_at timestamp NOT NULL,
              delivered_at timestamp DEFAULT NULL
            )
        SQL
        );
    }
}
