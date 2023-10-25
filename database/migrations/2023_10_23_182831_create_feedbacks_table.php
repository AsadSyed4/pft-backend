<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('feedbacks')) {
            Schema::create('feedbacks', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('category');
                $table->integer('vote_count')->default(0);
                $table->unsignedBigInteger('client_id');
                $table->timestamps();

                $table->foreign('client_id')->references('id')->on('clients')->onDelete('CASCADE')->onUpdate('CASCADE');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
