<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingcaritemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppingcaritems', function (Blueprint $table) {
            $table->id();
            $table->integer('idshoppingcar');
            $table->integer('idproducto');
            $table->string('name', 100);
            $table->text('description');
            $table->float('price', 8, 2);
            $table->integer('borrado')->default(0);
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
        Schema::dropIfExists('shoppingcaritems');
    }
}
