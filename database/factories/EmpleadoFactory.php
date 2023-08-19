<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Empleado;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Empleado::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'correo' => $this->faker->unique()->safeEmail,
            'puesto_id' => Puesto::factory(),
            'company_id' => Company::factory(),
            'fecha_ingreso' => $this->faker->date(),
        ];
    }
}
