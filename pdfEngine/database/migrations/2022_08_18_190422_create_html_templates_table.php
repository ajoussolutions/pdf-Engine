<?php

use App\Models\HtmlTemplate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHtmlTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('html_templates', function (Blueprint $table) {
            $table->id();
            $table->text('templatecode')->nullable()->default('');
            $table->string('templatename')->unique();
            $table->text('sampledata')->nullable()->default('');
            $table->text('description')->nullable();
            $table->foreignIdFor(HtmlTemplate::class,'header')->nullable();
            $table->foreignIdFor(HtmlTemplate::class,'footer')->nullable();
            $table->json('options')->nullable();
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
        Schema::dropIfExists('html_templates');
    }
}
