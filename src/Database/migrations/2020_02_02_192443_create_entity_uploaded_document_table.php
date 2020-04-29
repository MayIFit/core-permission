<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityUploadedDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_uploaded_document', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id')->references('id')->on('uploaded_documents');
            $table->unsignedBigInteger('entity_id')->references('id');
            $table->primary(['product_photo_id', 'entity']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_uploaded_document');
    }
}
