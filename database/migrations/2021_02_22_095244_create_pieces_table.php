<?php
/*Tabla piezas que podrá tener un usuario */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger('user_id');
            $table->string("img")->nullable();;
            $table->string("description");
            $table->boolean('sold');
            $table->integer('total_materials');
            $table->timestamps();

            //Foreigns:
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pieces');
    }
}
