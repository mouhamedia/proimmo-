<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute la colonne 'role' à la table users si elle n'existe pas.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('manager');
            });
        }
        if (!Schema::hasColumn('users', 'residence_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('residence_id')->nullable();
            });
        }
    }

    /**
     * Supprime les colonnes ajoutées.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
        if (Schema::hasColumn('users', 'residence_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('residence_id');
            });
        }
    }
};
