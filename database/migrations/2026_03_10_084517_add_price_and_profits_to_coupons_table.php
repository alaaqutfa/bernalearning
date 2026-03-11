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
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable()->after('level_id');                // سعر الكوبون وقت الإنشاء
            $table->decimal('profit_owner', 8, 2)->nullable()->after('price');            // ربح بيرنا (75%)
            $table->decimal('profit_developer', 8, 2)->nullable()->after('profit_owner'); // ربح المطور (25%)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['price', 'profit_owner', 'profit_developer']);
        });
    }
};
