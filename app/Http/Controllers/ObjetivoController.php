<?php

namespace App\Http\Controllers;

use App\Models\Objetivo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ObjetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objetivos = Objetivo::orderBy('idObjetivo')->paginate(15);
        return view('objetivos.index', compact('objetivos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextId = Objetivo::max('idObjetivo') + 1;
        $codigoSiguiente = 'OB-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        return view('objetivos.create', compact('codigoSiguiente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo'          => 'nullable|string|max:20|unique:objetivos,codigo',
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'tipo'            => ['required', Rule::in(['Institucional','ODS','PND'])],
            'vigencia_desde'  => 'nullable|date',
            'vigencia_hasta'  => 'nullable|date|after_or_equal:vigencia_desde',
            'estado'          => 'boolean',
        ]);

        Objetivo::create($request->all());

        return redirect()->route('objetivos.index')->with('success', 'Objetivo creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $objetivo = Objetivo::with(['programas'=> fn ($q) => $q->withCount('planes'),'audits.user',])->findOrFail($id);

        return view('objetivos.show', compact('objetivo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $objetivo = Objetivo::findOrFail($id);
        return view('objetivos.edit', compact('objetivo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $objetivo = Objetivo::findOrFail($id);

        $request->validate([
            'codigo'          => ['nullable','string','max:20',Rule::unique('objetivos','codigo')->ignore($objetivo->idObjetivo,'idObjetivo')],
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'tipo'            => ['required', Rule::in(['Institucional','ODS','PND'])],
            'vigencia_desde'  => 'nullable|date',
            'vigencia_hasta'  => 'nullable|date|after_or_equal:vigencia_desde',
            'estado'          => 'boolean',
        ]);

        $objetivo->update($request->all());

        return redirect()->route('objetivos.index')->with('success', 'Objetivo actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $objetivo = Objetivo::findOrFail($id);
        $objetivo->delete();
        return redirect()->route('objetivos.index')->with('success', 'Objetivo eliminado satisfactoriamente');
    }

    public function ByObjetivo(int $objetivo)
    {
        return response()->json($objetivo->programas()->select('id', 'nombre')->orderBy('nombre')->get());
    }
}
