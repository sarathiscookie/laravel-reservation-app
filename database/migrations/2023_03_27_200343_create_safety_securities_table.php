<?php

use App\Models\SafetySecurity;
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
        Schema::create('safety_securities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->foreignId('hotel_id')->constrained();
            $table->enum('status', [SafetySecurity::ACTIVE, SafetySecurity::DISABLED])->default(SafetySecurity::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_securities');
    }
};
