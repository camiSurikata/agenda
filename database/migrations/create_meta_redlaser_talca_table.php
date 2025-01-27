
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaTalcaRedlaserTable extends Migration
{
    public function up()
    {
        Schema::create('meta_talca_redlaser', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('alcance');
            $table->integer('impresiones');
            $table->integer('conversaciones');
            $table->decimal('porConversaciones', 8, 2); // Asegúrate de que coincida con el tipo en el modelo
            $table->decimal('importeGastado', 8, 2); // Asegúrate de que coincida con el tipo en el modelo
            $table->timestamps(); // Opcional, si decides usar timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('meta_talca_redlaser');
    }
}
