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
        Schema::table('buildings', function (Blueprint $table) {
            if (!Schema::hasColumn('buildings', 'residence_id')) {
                $table->unsignedBigInteger('residence_id')->nullable()->after('floors');
                $table->foreign('residence_id')->references('id')->on('residences')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            if (Schema::hasColumn('buildings', 'residence_id')) {
                $table->dropForeign(['residence_id']);
                $table->dropColumn('residence_id');
            }
        });
    }
};
