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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('text')->nullable();
            $table->text('admin_text')->nullable();
            $table->enum('type', ['общий клининг','генеральная уборка','послестроительная уборка','химчистка ковров и мебели','иная услуга']);
            $table->enum('pay', ['наличные','банковская карта']);
            $table->dateTime('date');
            $table->text('address');
            $table->string('phone');
            $table->enum('status', ['создано', 'в работе','выполнено', 'отменено'])->default('создано');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
