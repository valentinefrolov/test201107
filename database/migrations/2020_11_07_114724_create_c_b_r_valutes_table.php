<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBRValutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_b_r_valutes', function (Blueprint $table) {
            $table->id();
            $table->string('currency', 3)->unique()->nullable(false);
            $table->string('name')->nullable(false);
            $table->smallInteger('nominal')->default(1);
            $table->decimal('value', 10, 4)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_b_r_valutes');
    }
}
