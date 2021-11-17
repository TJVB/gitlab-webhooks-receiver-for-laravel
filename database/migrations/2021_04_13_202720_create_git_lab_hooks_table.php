<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGitLabHooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('git_lab_hooks', function (Blueprint $table) {
            $table->id();
            $table->string('object_kind')->nullable();
            $table->string('event_type')->nullable();
            $table->string('event_name')->nullable();
            $table->boolean('system_hook')->default(false);
            $table->jsonb('body');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('git_lab_hooks');
    }
}
