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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();                                        // رمز الكوبون الفريد
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // مرتبط بمستخدم بعد الدخول
            $table->foreignId('level_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable(); // صلاحية الكوبون (اختياري)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
