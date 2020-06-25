<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFulltextIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE clients ADD FULLTEXT INDEX fulltext_index (name, lastname)');
        DB::statement('ALTER TABLE phones ADD FULLTEXT INDEX fulltext_index (phone)');
        DB::statement('ALTER TABLE emails ADD FULLTEXT INDEX fulltext_index (email)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE clients DROP INDEX `fulltext_index`');
        DB::statement('ALTER TABLE phones DROP INDEX `fulltext_index`');
        DB::statement('ALTER TABLE emails DROP INDEX `fulltext_index`');
    }
}
