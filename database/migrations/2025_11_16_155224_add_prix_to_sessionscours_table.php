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
        Schema::table('sessionscours', function (Blueprint $table) {
            $table->decimal('prix', 10, 2)->default(0)->after('nom_cours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessionscours', function (Blueprint $table) {
            $table->dropColumn('prix');
        });
    }
};
