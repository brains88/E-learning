<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    

    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Reference to the user
            $table->text('message')->nullable(); // Student's message
            $table->text('reply')->nullable(); // Admin's reply
            $table->boolean('is_admin_reply')->default(false); // Indicates admin reply
            $table->unsignedBigInteger('admin_id')->nullable(); // Admin ID (optional)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
