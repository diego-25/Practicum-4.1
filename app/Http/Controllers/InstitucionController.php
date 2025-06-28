<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $institucion=Institucion::all();
        return view('instituciones.index', compact('institucion'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1) Obtiene el próximo AUTO_INCREMENT de la tabla
        $nextId = Institucion::max('idInstitucion') + 1;
        // 2) Hacer de 6 digitos
        $codigoSiguiente = str_pad($nextId, 6, '0', STR_PAD_LEFT);
        // 3) Envía la variable a la vista
        return view('instituciones.create', compact('codigoSiguiente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'siglas'   => 'nullable|string|max:50',
            'ruc'      => 'required|string|max:10|unique:instituciones,ruc',
            'email'    => 'required|email|max:255',
            'telefono' => 'required|string|max:10',
            'direccion'=> 'required|string|max:255',
            'estado'   => 'boolean'
        ]);

        Institucion::create($request->all());

        return redirect()->route('instituciones.index')->with('success', 'Institucion Creada Satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Institucion $instituciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $institucion=Institucion::findOrfail($id);
        return view('instituciones.edit', compact('institucion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $institucion = Institucion::findOrfail($id);
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'siglas'   => 'nullable|string|max:50',
            'ruc'      => ['required','digits:10',Rule::unique('instituciones', 'ruc')->ignore($institucion->idInstitucion, 'idInstitucion') ],
            'email'    => 'required|email|max:255',
            'telefono' => 'required|string|max:10',
            'direccion'=> 'required|string|max:255',
            'estado'   => 'boolean'
        ]);

        $institucion->update($request->all());
        return redirect()->route('instituciones.index')->with('success', 'Institucion actualizada Satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $institucion=Institucion::findOrfail($id);
        $institucion->delete();
        return redirect()->route('instituciones.index')->with('success','Institucion eliminada satisfactoriamente');
    }
}

