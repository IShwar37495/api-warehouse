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
        Schema::create('apis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->string('base_url')->default('/api/v1/');
            $table->string('endpoint');
            $table->enum('method', ['GET', 'POST', 'PUT', 'PATCH', 'DELETE']);
            $table->enum('authentication', ['None', 'API Key', 'Bearer Token', 'OAuth2', 'Basic Auth']);
            $table->json('query_parameters')->nullable();
            $table->json('headers')->nullable();
            $table->json('path_parameters')->nullable();
            $table->json('request_body')->nullable();
            $table->json('response')->nullable();
            $table->timestamps();
            $table->unique(['endpoint', 'method']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apis');
    }
};
