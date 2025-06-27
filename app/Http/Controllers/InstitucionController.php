<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use Illuminate\Http\Request;

class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instituciones=Institucion::all();
        return view('instituciones.index', compact('instituciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instituciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'siglas'   => 'nullable|string|max:50',
            'ruc'      => 'required|string|max:13|unique:instituciones,ruc',
            'email'    => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
            'direccion'=> 'nullable|string|max:255',
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
        return view('instituciones.edit', compact('instituciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'siglas'   => 'nullable|string|max:50',
            'ruc'      => "required|string|max:13|unique:instituciones,ruc,{$institucion->id}",
            'email'    => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
            'direccion'=> 'nullable|string|max:255',
            'estado'   => 'boolean'
        ]);

        $institucion = Institucion::findOrfail($id);
        $institucion->update($request->all()); // error

        return redirect()->route('instituciones.index')->with('success', 'Intidad Actualizada Satisfactoriamente');
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

