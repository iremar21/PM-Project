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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('creator_user_id');
            $table->unsignedBigInteger('assigned_user_id');
            $table->unsignedBigInteger('plan_id');
            $table->dateTime('finishDate')->nullable();
            $table->dateTime('scheduledFinishDate');
            $table->boolean('completed');
            $table->string('slug')->unique();

            // Foreign keys

            $table->foreign('creator_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->cascadeOnUpdate();

            $table->foreign('assigned_user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('plan_id')
                ->references('id')
                ->on('plans')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
