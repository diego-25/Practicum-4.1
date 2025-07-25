<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Programa;
use Illuminate\Validation\Rule;
use App\Models\Objetivo;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planes = Plan::with('programa.objetivo')->orderBy('idPlan')->paginate(15);
        return view('planes.index', compact('planes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextId = Plan::max('idPlan') + 1;
        $codigoSiguiente = 'PL-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        $programas = Programa::orderBy('nombre')->pluck('nombre','idPrograma');

        //ajax
        $objetivos = Objetivo::orderBy('nombre')->pluck('nombre', 'idObjetivo');

        return view('planes.create', compact('codigoSiguiente','programas','objetivos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idPrograma'      => ['required','integer', Rule::exists('programas_institucionales','idPrograma')],
            'codigo'          => 'nullable|string|max:20|unique:planes_institucionales,codigo',
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'vigencia_desde'  => 'nullable|date',
            'vigencia_hasta'  => 'nullable|date|after_or_equal:vigencia_desde',
            'estado'          => 'boolean',
        ]);

        Plan::create($request->all());
        return redirect()->route('planes.index')->with('success','Plan creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $plan = Plan::with(['programa.objetivo','proyectos','audits.user',])->findOrFail($id);

        return view('planes.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        $programas = Programa::orderBy('nombre')->pluck('nombre','idPrograma');

        //ajax
        $objetivos = Objetivo::orderBy('nombre')->pluck('nombre', 'idObjetivo');

        return view('planes.edit', compact('plan','programas','objetivos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);
        $request->validate([
            'idPrograma'      => ['required','integer', Rule::exists('programas_institucionales','idPrograma')],
            'codigo'          => ['nullable','string','max:20',Rule::unique('planes_institucionales','codigo')->ignore($plan->idPlan,'idPlan')],
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'vigencia_desde'  => 'nullable|date',
            'vigencia_hasta'  => 'nullable|date|after_or_equal:vigencia_desde',
            'estado'          => 'boolean',
        ]);

        $plan->update($request->all());
        return redirect()->route('planes.index')->with('success','Plan actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return redirect()->route('planes.index')->with('success','Plan eliminado satisfactoriamente');
    }

    public function byPrograma(Programa $programa)
    {
        return response()->json(
            $programa->planes()->select('idPlan as value', 'nombre as text')->orderBy('nombre')->get()
        );
    }
}
