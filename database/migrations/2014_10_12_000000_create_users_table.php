<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('user_type_id')->constrained('roles')->onDelete('cascade');
            $table->string('user_status_id')->constrained('user_statuses')->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

        });

        $users = [
            [
                'first_name' => 'Admin',
                'last_name' =>'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make(   'password'),
                'user_type_id' => 1,
                'user_status_id' => 1,
            ],
        ];

        foreach($users as $user){
            User::create($user);
        }

        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
