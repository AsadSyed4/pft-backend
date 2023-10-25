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
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('feedback_id');
                $table->text('content');
                $table->tinyInteger('visible')->default(true);
                $table->timestamps();

                $table->foreign('client_id')->references('id')->on('clients')->onDelete('CASCADE')->onUpdate('CASCADE');
                $table->foreign('feedback_id')->references('id')->on('feedbacks')->onDelete('CASCADE')->onUpdate('CASCADE');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
