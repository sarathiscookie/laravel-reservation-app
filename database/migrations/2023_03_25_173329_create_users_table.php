<?php

use App\Enum\StatusEnum;
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
            $table->foreignId('role_id')->constrained();
            $table->uuid('uuid')->unique();
            $table->string('name', 150);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('contact_number', 25);
            $table->foreignId('country_id')->constrained();
            $table->foreignId('state_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->text('address');
            $table->string('postcode', 15);
            $table->enum('status', [StatusEnum::ACTIVE->value, StatusEnum::DISABLED->value])->default(StatusEnum::ACTIVE->value);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
