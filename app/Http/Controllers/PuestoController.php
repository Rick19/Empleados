<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        // Obtengo el listado de compañías
        $puestos = Puesto::withTrashed()->orderby('name')->get();

        return view('puestos.index', compact('puestos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('puestos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /**
         * Se validan los datos que manda el usuario y sobreescribe los mensajes predeterminados.
         * En caso de no pasar la validación, de manera automática se devuelve a la vista
         * con los mensajes según el caso.
         */
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:puestos'],
        ], [
            'required' => 'Este campo es requerido.',
            'string' => 'Solo se aceptan cadenas.',
            'max' => 'Solo puedes agregar :max caracteres.',
            'unique' => 'Este puesto ya se encuentra registrado.',
        ]);

        //  Si la validación no falla, entonces permitirá continuar a las siguientes lineas de código.
        Puesto::create($request->all()); //   Se crea la "companie" gracias al modelo y los datos

        return back()->with('success', 'Puesto registrado correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Puesto $puesto
     * @return JsonResponse
     */
    public function update(Request $request, Puesto $puesto): JsonResponse
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => "required|unique:companies,name,{$puesto->id}", // Nombre único excepto el registro actual
        ]);

        try {
            // Actualizar los campos
            $puesto->name = $request->input('name');
            $puesto->save();

            return response()->json([
                'success' => true,
                'message' => 'Puesto actualizado con éxito'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Hubo un error al actualizar el puesto'], 500);
        }
    }

    /**
     * Restore the specified resource in storage.
     * @param $id
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        $puesto = Puesto::withTrashed()->where('id', $id)->first();
        $puesto->restore();

        return response()->json([
            'success' => true,
            'message' => "Se ha restaurado el puesto {$puesto->name}",
            'puesto' => $puesto
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Puesto $puesto
     * @return JsonResponse
     */
    public function destroy(Puesto $puesto): JsonResponse
    {
        $existRegistry = Empleado::where('company_id', $puesto->id)->first();
        if ($existRegistry)
            return response()->json([
                'success' => false,
                'message' => 'El puesto esta siendo usada en empleados.'
            ], 405);

        $puesto->delete();

        return response()->json([
            'success' => true,
            'message' => "El puesto {$puesto->name} se ha eliminado correctamente",
        ]);
    }
}
