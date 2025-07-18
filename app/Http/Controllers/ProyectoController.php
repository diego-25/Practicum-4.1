<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Validation\Rule;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyectos = Proyecto::with('plan.programa.objetivo')->orderBy('idProyecto')->paginate(15);
        return view('proyectos.index', compact('proyectos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextId=Proyecto::max('idProyecto') + 1;
        $codigoSiguiente='PRY-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        $planes = Plan::with('programa')->orderBy('nombre')->get()->mapWithKeys(fn ($plan) => [$plan->idPlan => $plan->nombre . ' — ' . $plan->programa->nombre]);
        $objetivos = Objetivo::orderBy('nombre')->pluck('nombre','idObjetivo');
        return view('proyectos.create', compact('codigoSiguiente', 'planes','objetivos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = $request->validate([
            'idPlan'            => ['required','integer',Rule::exists('planes','idPlan')],
            'codigo'            => 'nullable|string|max:20|unique:proyectos,codigo',
            'nombre'            => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'monto_presupuesto' => 'nullable|numeric|min:0',
            'fecha_inicio'      => 'nullable|date',
            'fecha_fin'         => 'nullable|date|after_or_equal:fecha_inicio',
            'estado'            => 'boolean',
        ]);

        $plan=PlanInstitucional::findOrFail($request->idPlan);
        $request['idPrograma'] = $plan->idPrograma;
        
        Proyecto::create($request->all());

        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyecto $Proyecto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $planes = Plan::with('programa')->orderBy('nombre')->get()->mapWithKeys(fn ($plan) => [
            $plan->idPlan=>$plan->nombre . ' — ' . $plan->programa->nombre
        ]);

        return view('proyectos.edit', compact('proyecto', 'planes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $request->validate([
            'idPlan'=>['required','integer',Rule::exists('planes','idPlan')],
            'codigo'=>['nullable','string','max:20',Rule::unique('proyectos','codigo')->ignore($proyecto->idProyecto,'idProyecto')],
            'nombre'=>'required|string|max:255',
            'descripcion'=>'nullable|string',
            'monto_presupuesto'=>'nullable|numeric|min:0',
            'fecha_inicio'=>'nullable|date',
            'fecha_fin'=>'nullable|date|after_or_equal:fecha_inicio',
            'estado'=>'boolean',
        ]);

        $plan=PlanInstitucional::findOrFail($request->idPlan);
        $request['idPrograma'] = $plan->idPrograma;
        $proyecto->update($request->all());

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->delete();
        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado satisfactoriamente');
    }
}
