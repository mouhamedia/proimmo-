<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('apartments', 'access_code')) {
            Schema::table('apartments', function (Blueprint $table) {
                $table->string('access_code')->unique()->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropColumn('access_code');
        });
    }
};
