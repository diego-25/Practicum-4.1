<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Programa;
use Illuminate\Validation\Rule;

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
        $nextId         = Plan::max('idPlan') + 1;
        $codigoSiguiente = 'PL-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        $programas = Programa::orderBy('nombre')->pluck('nombre','idPrograma');
        return view('planes.create', compact('codigoSiguiente','programas'));
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
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        $programas = Programa::orderBy('nombre')->pluck('nombre','idPrograma');
        return view('planes.edit', compact('plan','programas'));
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

    public function ajaxByPrograma(int $programa)
    {
        return PlanInstitucional::where('idPrograma', $programa)->orderBy('nombre')->pluck('nombre', 'idPlan');
    }
}
