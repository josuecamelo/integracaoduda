<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('external_template_id')->unsigned();
            $table->string('preview_url');
            $table->string('thumbnail_url');
            $table->string('desktop_thumbnail_url');
            $table->string('tablet_thumbnail_url')->nullable();
            $table->string('mobile_thumbnail_url')->nullable();
            $table->string('template_name')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('templates');
    }
}
