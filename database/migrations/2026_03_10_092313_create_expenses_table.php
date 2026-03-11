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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    // عنوان المصروف
            $table->text('description')->nullable();    // وصف
            $table->decimal('amount', 10, 2);           // المبلغ
            $table->string('currency')->default('USD'); // العملة
            $table->enum('type', [
                'hosting',   // استضافة
                'domain',    // دومين
                'bunny_cdn', // خدمات Bunny.net
                'marketing', // تسويق
                'other',     // أخرى
            ])->default('other');
            $table->date('expense_date');                    // تاريخ المصروف
            $table->string('receipt_path')->nullable();      // صورة الفاتورة
            $table->boolean('is_recurring')->default(false); // هل هو مصروف دوري؟
            $table->integer('recurring_months')->nullable(); // كل كم شهر يتكرر؟
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
