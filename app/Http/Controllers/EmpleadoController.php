<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Empleado;
use App\Models\Puesto;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $empleados = Empleado::withTrashed()
            ->with('company')
            ->with('puesto')
            ->get();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $companies = Company::select('*')->orderBy('alias')->get();
        $puestos = Puesto::select('id', 'name')->orderBy('name')->get();

        return view('empleados.create', compact('companies', 'puestos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido_paterno' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido_materno' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'correo' => 'required|email|unique:empleados',
            'company' => 'required|exists:companies,id',
            'fecha_ingreso' => 'required|date_format:Y-m-d|after:01/01/2000',
            'puesto' => 'required|exists:puestos,id',
        ], [
            'required' => 'El campo :attribute es requerido.',
            'string' => 'El formato del campo :attribute es inválido.',
            'fecha_ingreso.after' => 'La fecha de ingreso debe ser posterior al 2000.',
            'min' => 'La :attribute debe tener al menos :min caracteres.',
            'regex' => 'El formato del campo :attribute es inválido.',
            'email' => 'Ingresa un correo válido en el campo :attribute.',
            'exists' => 'El dato seleccionado en el campo :attribute no se encuentra en la base de datos.',
            'date_format' => 'El formato del campo :attribute debe ser yyyy-mm-dd.',
            'date' => 'Debes indicar una fecha en el campo :attribute.',
            'unique' => 'El dato ingresado en el campo :attribute ya existe.',
            'fecha_ingreso.before_or_equal' => 'La fecha de ingreso en el campo :attribute debe ser válida y no mayor a un año.',
        ]);


        Empleado::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'correo' => $request->correo,
            'puesto_id' => $request->puesto,
            'company_id' => $request->company,
            'fecha_ingreso' => $request->fecha_ingreso,
        ]);

        return redirect()->back()->with('success', 'Empleado registrado correctamente');
    }


    /**
     * Display the specified resource.
     *
     * @param Empleado $empleado
     * @return Application|Factory|View
     */
    public function show(Empleado $empleado): View|Factory|Application
    {
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Empleado $empleado
     * @return Application|Factory|View
     */
    public function edit(Empleado $empleado): View|Factory|Application
    {
        $companies = Company::select('*')->orderBy('alias')->get();
        $puestos = Puesto::select('*')->orderBy('name')->get();

        return view('empleados.edit', compact('empleado', 'companies', 'puestos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Empleado $empleado
     * @return RedirectResponse
     */
    public function update(Request $request, Empleado $empleado): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido_paterno' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido_materno' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'correo' => 'required|email|unique:empleados,correo,' . $empleado->id,
            'company' => 'required|exists:companies,id',
            'fecha_ingreso' => 'required|date_format:Y-m-d|after:2000-01-01',
            'puesto' => 'required|exists:puestos,id',
        ], [
            'required' => 'El campo :attribute es requerido.',
            'string' => 'El formato del campo :attribute es inválido.',
            'fecha_ingreso.after' => 'La fecha de ingreso debe ser posterior al año 2000.',
            'regex' => 'El formato del campo :attribute es inválido.',
            'email' => 'Ingresa un correo válido en el campo :attribute.',
            'exists' => 'El dato seleccionado en el campo :attribute no se encuentra en la base de datos.',
            'date_format' => 'El formato del campo :attribute debe ser yyyy-mm-dd.',
            'date' => 'Debes indicar una fecha en el campo :attribute.',
            'unique' => 'El dato ingresado en el campo :attribute ya existe.',
        ]);

        $empleado->nombre = $request->nombre;
        $empleado->apellido_paterno = $request->apellido_paterno;
        $empleado->apellido_materno = $request->apellido_materno;
        $empleado->correo = $request->correo;
        $empleado->puesto_id = $request->puesto;
        $empleado->company_id = $request->company;
        $empleado->fecha_ingreso = $request->fecha_ingreso;

        $empleado->save();

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente');
    }

    /**
     * Restore the specified resource from storage
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        $empleado = Empleado::withTrashed()->where('id', $id)->first();
        $empleado->restore();

        return redirect()->back()->with('success', "Se ha restaurado el empleado {$empleado->nombre}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Empleado $empleado
     * @return RedirectResponse
     */
    public function destroy(Empleado $empleado): RedirectResponse
    {
        $empleado->delete();

        return redirect()->back()->with('success',"El empleado {$empleado->name} se ha eliminado correctamente");
    }
}
