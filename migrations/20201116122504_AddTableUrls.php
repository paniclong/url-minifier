<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Phpmig\Migration\Migration;

class AddTableUrls extends Migration
{
    /**
     * Do the migration
     */
    public function up(): void
    {
        $schema = Manager::schema();

        $schema->create('urls', static function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('uuid', 255)->unique()->nullable(false);
            $table->string('url', 2048)->nullable(false);
            $table->timestamp('created_at')->useCurrent()->nullable(false);
            $table->timestamp('updated_at')->useCurrent()->nullable(false);
            $table->timestamp('expires_at')->nullable(true);
        });
    }

    /**
     * Undo the migration
     */
    public function down(): void
    {
        $schema = Manager::schema();

        $schema->dropIfExists('urls');
    }
}
