<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Empleado;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmpleadoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get('/empleados');

        $response->assertStatus(200);
        $response->assertViewIs('empleados.index');
        // Asegurarse de que los datos de los empleados se pasen a la vista
        $response->assertViewHas('empleados', Empleado::all());
    }

    public function testCreate()
    {
        $response = $this->get('/empleados/create');

        $response->assertStatus(200);
        $response->assertViewIs('empleados.create');
    }

    public function testStore()
    {
        $response = $this->post('/empleados', [
            // Datos válidos para crear un empleado
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/empleados');
        $this->assertCount(1, Empleado::all());
    }

    public function testEdit()
    {
        $empleado = Empleado::factory()->create();

        $response = $this->get("/empleados/{$empleado->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('empleados.edit');
        $response->assertViewHas('empleado', $empleado);
    }

    public function testUpdate()
    {
        $empleado = Empleado::factory()->create();

        $response = $this->patch("/empleados/{$empleado->id}", [
            // Datos válidos para actualizar un empleado
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/empleados');
        $this->assertEquals($newData, $empleado->fresh()->toArray());
    }

    public function testDestroy()
    {
        $empleado = Empleado::factory()->create();

        $response = $this->delete("/empleados/{$empleado->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/empleados');
        $this->assertCount(0, Empleado::all());
    }



    public function testListadoDeEmpleados()
    {
        $empleados = Empleado::factory(5)->create();

        $response = $this->get('/empleados');

        $response->assertStatus(200);
        $response->assertSee($empleados[0]->nombre);
    }

    public function testCrearEmpleado()
    {
        $company = Company::factory()->create();
        $puesto = Puesto::factory()->create();

        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(), // Agrega el token CSRF en las cabeceras
        ])->post('/empleados', [
            'nombre' => 'Carlos Ramirez',
            'apellido_paterno' => 'Ramirez',
            'apellido_materno' => 'Carlos',
            'correo' => 'carlos@example.com',
            'company' => $company->id,
            'fecha_ingreso' => '2023-08-11',
            'puesto' => $puesto->id,
        ]);

        $response->assertStatus(302);
        $this->assertCount(1, Empleado::all());
    }

    public function testActualizarEmpleado()
    {
        $empleado = Empleado::factory()->create();
        $nuevoNombre = 'Nuevo Nombre';

        $response = $this->put('/empleados/' . $empleado->id, [
            'nombre' => $nuevoNombre,
        ]);

        $response->assertStatus(302);
        $this->assertEquals($nuevoNombre, $empleado->fresh()->nombre);
    }

    public function testEliminarEmpleado()
    {
        $empleado = Empleado::factory()->create();

        $response = $this->delete('/empleados/' . $empleado->id);

        $response->assertStatus(302);
        $this->assertCount(0, Empleado::all());
    }
}
