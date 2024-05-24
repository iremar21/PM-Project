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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('category_id');
            $table->decimal('status', 5, 2)->default(0)->comment('Percentage completed');
            $table->boolean('completed')->default(false);
            $table->unsignedBigInteger('creator_user_id');
            $table->unsignedBigInteger('manager_user_id');
            $table->dateTime('creationDate');
            $table->dateTime('finishDate')->nullable();
            $table->dateTime('scheduledFinishDate');
            $table->string('slug')->unique();

            // Foreign keys
            $table->foreign('category_id')->nullable()
                ->references('id')
                ->on('categories')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('creator_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            
            $table->foreign('manager_user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
