<?php

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
            $table->string('user_id')->primary()->unique();
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->decimal('age', 4,1)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Prefer not to say', 'Other'])->nullable();
            $table->string('country');
            $table->string('state_province');
            $table->string('city');
            $table->enum('subscription_plan', ['Standard', 'Premium', 'Basic', 'Premium+']);
            $table->date('subscription_start_date');
            $table->boolean('is_active')->default(false);
            $table->decimal('monthly_spend')->nullable();
            $table->string('primary_device');
            $table->float('household_size')->nullable();
            $table->timestamp('created_at');
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
