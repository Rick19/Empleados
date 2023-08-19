<?php

use App\Models\Company;
use App\Models\Puesto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('correo');
            // Se asigna una llave foránea para el modelo específico aplicando Eloquent
            $table->foreignIdFor(Puesto::class);
            $table->foreignIdFor(Company::class);
            $table->date('fecha_ingreso');
            $table->softDeletes();  // para borrado lógico
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
        Schema::dropIfExists('empleados');
    }
};
