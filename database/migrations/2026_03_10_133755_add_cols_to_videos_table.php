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
        Schema::table('videos', function (Blueprint $table) {
            $table->integer('duration')->nullable()->after('bunny_video_id');
            $table->integer('width')->nullable()->after('duration');
            $table->integer('height')->nullable()->after('width');
            $table->string('available_resolutions')->nullable()->after('height');
            $table->string('thumbnail_file_name')->nullable()->after('available_resolutions');
            $table->tinyInteger('status')->default(0)->after('thumbnail_file_name');
            $table->bigInteger('storage_size')->nullable()->after('status');
            $table->integer('views')->default(0)->after('storage_size');
            $table->timestamp('uploaded_at')->nullable()->after('views');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn([
                'duration',
                'width',
                'height',
                'available_resolutions',
                'thumbnail_file_name',
                'status',
                'storage_size',
                'views',
                'uploaded_at',
            ]);
        });
    }
};
