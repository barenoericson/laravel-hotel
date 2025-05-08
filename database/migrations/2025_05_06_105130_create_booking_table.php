<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->date('check_in');
            $table->date('check_out');
            $table->string('status')->default('pending');
            $table->timestamps();
            
            // Remove any duplicate column definitions
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};