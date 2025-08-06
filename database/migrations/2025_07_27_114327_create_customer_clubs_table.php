<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_clubs', function (Blueprint $table) {
            $table->id();
			$table->string('first_name', 50)->nullable(); 
			$table->string('last_name', 50)->nullable();        
			$table->string('sales_person', 100)->nullable();    
			$table->string('mobile', 15)->nullable();           
			$table->string('area', 100)->nullable();            
$table->string('invoice_image', 255)->nullable();   
$table->string('project_image', 255)->nullable(); 
$table->char('card_number', 16)->nullable();        

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
        Schema::dropIfExists('customer_clubs');
    }
}
