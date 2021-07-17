<?php

use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->enum('type', ['pickup', 'delivery']);
            $table->enum('status', ['pending', 'in_transit', 'delivered', 'cancelled']);
            $table->foreignIdFor(Address::class);
            $table->unsignedInteger('total')->default(0);
            $table->text('order_location')->default(null)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
