<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Agregar las nuevas columnas
            $table->dropColumn([
                'status'
            ]);

            $table->string('slug')->unique();
            $table->enum('status', ['draft', 'published', 'archived', 'default'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->string('cover_image')->nullable();

            $table->json('meta')->nullable();
            $table->json('tags')->nullable();

            $table->softDeletes();

            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table){
            $table->dropIndex(['status', 'published_at']);

            $table->dropColumn([
                'slug',
                'published_at',
                'cover_image',
                'meta',
                'tags',
                'deleted_at'
            ]);
            $table->boolean('status')->change();
        });
    }
};
