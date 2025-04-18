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
        Schema::table('password_resets', function (Blueprint $table) {
            $table->string('ip')->after('token');
            $table->string('phone')->nullable()->change();
            $table->string('email')->nullable()->index()->after('phone');
            $table->integer('attempts')->default(1)->after('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropColumn(['attempts', 'ip', 'email']);

            $table->string('phone')->change();
        });
    }
};
