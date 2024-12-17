<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE OR REPLACE VIEW 
        vw_users AS SELECT usr.name AS full_name, usr.email AS email, pro.username AS username, pro.status AS current_status   
        FROM users AS usr
        LEFT JOIN profiles AS pro ON pro.user_id = usr.id
        ORDER BY usr.id DESC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_users");
    }
};
