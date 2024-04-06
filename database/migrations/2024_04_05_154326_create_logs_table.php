<?php

use PhpClickHouseLaravel\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        static::write('
            CREATE TABLE logs (
                id UInt32,
                created_at DateTime,
                field_one String,
                field_two Int32
            )
            ENGINE = MergeTree()
            ORDER BY (id)
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
