<?php

use App\Models\Settlement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesAgencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('sales_agency', function (Blueprint $table) {
            $table->id();
            $table->string('name');
			$table->string('company_name')->nullable();
			$table->string('registration_number')->nullable();
			$table->string('website')->nullable();
			$table->string('fax')->nullable();
			$table->string('project_title')->nullable();
            $table->string('level_of_education');
			$table->date('start_activity_date')->nullable();
			$table->text('activity_topic_description')->nullable();
			$table->boolean('has_elling_software_products')->default(false);
            $table->date('bith_of_date');
			$table->string('method_of_introduction')->nullable();
            $table->string('field_of_education')->nullable();
			$table->string('education_place')->nullable();
			$table->string('military_status')->nullable();
			$table->boolean('is_married')->default(false);
			$table->boolean('has_work_experience')->default(false);
			$table->string('mobile');
			$table->text('work_experience_description')->nullable();
			$table->text('description')->nullable();
			$table->string('phone_number')->nullable();
			$table->string('email')->nullable();
			$table->string('province')->nullable();
			$table->string('city')->nullable();
			$table->text('address')->nullable();
			$table->string('cv')->nullable();
			$table->timestamp('viewed_at')->nullable();
            $table->timestamps();
        });
		Schema::create('sales_agency_product', function (Blueprint $table) {
            $table->foreignId('sales_agency_id')
                ->references('id')
                ->on('sales_agency')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
			$table->foreignId('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('sales_agency_product');
        Schema::dropIfExists('sales_agency');
    }
}
