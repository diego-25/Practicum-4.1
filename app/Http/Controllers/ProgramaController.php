<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;
use App\Models\Objetivo;
use Illuminate\Validation\Rule;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programas=Programa::with('objetivo')->orderBy('idPrograma')->paginate(15);
        return view('programas.index', compact('programas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextId=Programa::max('idPrograma') + 1;
        $codigoSiguiente='PR-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        $objetivos=Objetivo::orderBy('nombre')->pluck('nombre', 'idObjetivo');
        return view('programas.create', compact('codigoSiguiente', 'objetivos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idObjetivo'=>['required', 'integer',Rule::exists('objetivos', 'idObjetivo')],
            'codigo'=>'nullable|string|max:20|unique:programas,codigo',
            'nombre'=>'required|string|max:255',
            'descripcion'=>'nullable|string',
            'vigencia_desde'=>'nullable|date',
            'vigencia_hasta'=>'nullable|date|after_or_equal:vigencia_desde',
            'estado'=>'boolean',
        ]);

        Programa::create($request->all());

        return redirect()->route('programas.index')->with('success', 'Programa creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Programa $programa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $programa=Programa::findOrFail($id);
        $objetivos=Objetivo::orderBy('nombre')->pluck('nombre', 'idObjetivo');
        return view('programas.edit', compact('programa', 'objetivos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $programa   = Programa::findOrFail($id);
        $request->validate([
            'idObjetivo'=>['required', 'integer',Rule::exists('objetivos','idObjetivo')],
            'codigo'=>['nullable','string','max:20',Rule::unique('programas_institucionales','codigo')->ignore($programa->idPrograma, 'idPrograma')],
            'nombre'=>'required|string|max:255',
            'descripcion'=>'nullable|string',
            'vigencia_desde'=>'nullable|date',
            'vigencia_hasta'=>'nullable|date|after_or_equal:vigencia_desde',
            'estado'=>'boolean',
        ]);

        $programa->update($request->all());

        return redirect()->route('programas.index')->with('success', 'Programa actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $programa=Programa::findOrFail($id);
        $programa->delete();

        return redirect()->route('programas.index')->with('success', 'Programa eliminado satisfactoriamente');
    }

    public function byPrograma(\App\Models\Programa $programa): \Illuminate\Http\JsonResponse
    {
        return response()->json($programa->planes()->select('id', 'nombre')->orderBy('nombre')->get());
    }
}
