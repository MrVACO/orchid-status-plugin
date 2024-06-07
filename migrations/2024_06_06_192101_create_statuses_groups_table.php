<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statuses_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('statuses_rel_groups', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('group_id')->unsigned();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses_groups');
        Schema::dropIfExists('statuses_rel_groups');
    }
};
