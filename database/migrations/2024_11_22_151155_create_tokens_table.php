<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('pat_id'); // Foreign key to personal_access_tokens
            $table->string('token'); // Token value
            $table->timestamps();

            // Define the foreign key constraint with restrict on delete
            $table->foreign('pat_id')
                ->references('id')
                ->on('personal_access_tokens')
                ->onDelete('restrict'); // Restrict delete when referenced in tokens
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tokens');
    }
};
