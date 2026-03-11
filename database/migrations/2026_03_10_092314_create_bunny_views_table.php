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
        Schema::create('bunny_views', function (Blueprint $table) {
            $table->id();
            $table->string('bunny_video_id'); // معرف الفيديو في Bunny
            $table->foreignId('video_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address')->nullable();             // عنوان IP
            $table->string('country')->nullable();                // البلد (من Bunny)
            $table->integer('watch_time')->default(0);            // مدة المشاهدة بالثواني
            $table->boolean('completed')->default(false);         // هل شاهد الفيديو كاملاً؟
            $table->decimal('bandwidth_used', 10, 2)->default(0); // حجم البيانات المستهلكة (GB)
            $table->timestamp('viewed_at');                       // وقت المشاهدة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bunny_views');
    }
};
