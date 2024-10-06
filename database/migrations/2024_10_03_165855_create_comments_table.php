<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Veza sa posts tabelom
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Veza sa users tabelom
            $table->text('comment');
            $table->timestamps(); // created_at i updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
