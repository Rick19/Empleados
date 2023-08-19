<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Empleado;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        // Obtengo el listado de compañías
        $companies = Company::withTrashed()->orderby('alias')->get();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('companies.create');
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
            'name' => ['required', 'string', 'max:255', 'unique:companies'],
            'alias' => ['required', 'string', 'max:50', 'unique:companies'],
        ], [
            'required' => 'Este campo es requerido.',
            'string' => 'Solo se aceptan cadenas.',
            'max' => 'Solo puedes agregar :max caracteres.',
            'unique' => 'Esta empresa ya se encuentra registrada.',
        ]);

        //  Si la validación no falla, entonces permitirá continuar a las siguientes lineas de código.
        Company::create($request->all()); //   Se crea la "companie" gracias al modelo y los datos

        return back()->with('success', 'Compañía registrada correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Company $companie
     * @return JsonResponse
     */
    public function update(Request $request, Company $company): JsonResponse
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => "required|unique:companies,name,{$company->id}", // Nombre único excepto el registro actual
            'alias' => 'required',
        ]);

        try {
            // Actualizar los campos
            $company->name = $request->input('name');
            $company->alias = $request->input('alias');
            $company->save();

            return response()->json([
                'success' => true,
                'message' => 'Compañía actualizada con éxito'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Hubo un error al actualizar la compañía'], 500);
        }
    }

    /**
     * Restore the specified resource in storage.
     * @param Company $company
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        $company = Company::withTrashed()->where('id', $id)->first();
        $company->restore();

        return response()->json([
            'success' => true,
            'message' => "Se ha restaurado la compañía {$company->name} [{$company->alias}]",
            'company' => $company
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $companie
     * @return JsonResponse
     */
    public function destroy(Company $company): JsonResponse
    {
        $existRegistry = Empleado::where('company_id', $company->id)->first();
        if ($existRegistry)
            return response()->json([
                'success' => false,
                'message' => 'La compañía esta siendo usada en empleados.'
            ], 405);

        $company->delete();

        return response()->json([
            'success' => true,
            'message' => "La compañía {$company->name} [{$company->alias}] se ha eliminado correctamente",
        ]);
    }
}
