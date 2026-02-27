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
        // Met à jour tous les utilisateurs pour qu'ils aient le rôle 'manager'
        DB::table('users')->update(['role' => 'manager']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionnel : ne fait rien en rollback
    }
};
