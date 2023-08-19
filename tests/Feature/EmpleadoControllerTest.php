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
        $response->assertViewHas('empleados', Empleado::all());
    }

    public function testCreate()
    {
        $response = $this->get('/empleados/create');

        $response->assertStatus(200);
        $response->assertViewIs('empleados.create');
    }
}
