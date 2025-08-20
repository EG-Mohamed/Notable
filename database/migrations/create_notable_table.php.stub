<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('notable.table_name', 'notables'), function (Blueprint $table) {
            $table->id();
            $table->text('note');
            $table->morphs('notable');
            $table->nullableMorphs('creator');
            $table->timestamps();

        });
    }
};
