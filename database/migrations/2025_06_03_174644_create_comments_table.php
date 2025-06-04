<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('comments', function (Blueprint $table) {
    $table->id(); // alias bigIncrements('id')
    $table->unsignedBigInteger('pengaduan_id'); // harus unsignedBigInteger
    $table->unsignedBigInteger('user_id'); // asumsikan user_id juga unsignedBigInteger
    $table->text('comment');
    $table->timestamps();

    $table->foreign('pengaduan_id')->references('id')->on('pengaduan')->onDelete('cascade');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});

}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
