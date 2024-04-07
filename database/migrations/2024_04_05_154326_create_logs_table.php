<?php

use PhpClickHouseLaravel\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        static::write('
            CREATE TABLE IF NOT EXISTS logs (
                remote_addr String,
                remote_user String,
                time_local DateTime,
                request String,
                status Int32,
                body_bytes_sent Int32,
                http_referer String,
                http_user_agent String
            ) ENGINE = MergeTree()
            PARTITION BY toYYYYMM(time_local)
            ORDER BY (time_local)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        static::write('DROP TABLE logs');
    }
};
