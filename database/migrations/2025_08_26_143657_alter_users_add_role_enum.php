<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // kalau role sudah ada tinggal ubah tipe nya
            $table->enum('role', ['HR', 'User', 'Procurement', 'Manager'])
                  ->default('User')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['HR', 'User'])->default('User')->change();
        });
    }
};
