<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Models\Institucion;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::with(['roles', 'instituciones'])->orderBy('idUsuario')->paginate(15);
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles  = Role::pluck('name', 'id');
        $actors = array_keys(User::ACTOR_ROLE_MAP);
        $instituciones = Institucion::orderBy('nombre')->pluck('nombre', 'idInstitucion');
        return view('usuarios.create', compact('roles','actors','instituciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'telefono' => 'required|digits:10',
            'cargo'    => 'required|string|max:100',
            'estado'   => 'boolean',
            'actor'    => ['required', Rule::in(array_keys(User::ACTOR_ROLE_MAP))],
            'instituciones'   => 'array',
            'instituciones.*' => ['integer', Rule::exists('instituciones','idInstitucion')],
        ]);

        DB::transaction(function () use ($request) {
            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password,
                'telefono' => $request->telefono,
                'cargo'    => $request->cargo,
                'estado'   => $request->boolean('estado', true),
                'actor'    => $request->actor,
                'email_verified_at' => now(),
            ]);
            $user->instituciones()->sync($request->input('instituciones', []));
        });
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user   = User::findOrFail($id);
        $roles  = Role::pluck('name', 'id');
        $actors = array_keys(User::ACTOR_ROLE_MAP);
        $instituciones  = Institucion::orderBy('nombre')->pluck('nombre', 'idInstitucion');
        $userInstituciones = $user->instituciones->pluck('idInstitucion')->all();
        return view('usuarios.edit', compact('user','roles','actors','instituciones','userInstituciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => ['required','email','max:255',Rule::unique('users','email')->ignoreModel($user),],
            'password'  => 'nullable|min:8|confirmed',
            'telefono'  => 'required|digits:10',
            'cargo'     => 'required|string|max:100',
            'estado'    => 'boolean',
            'actor'     => ['required', Rule::in(array_keys(User::ACTOR_ROLE_MAP))],
            'roles'     => 'array',
            'roles.*'   => ['integer', Rule::exists('roles','id')],
            'instituciones'     => 'array',
            'instituciones.*'   => ['integer', Rule::exists('instituciones', 'idInstitucion')],
        ]);

        DB::transaction(function () use ($request, $user) {
            $data = $request->only(['name','email','telefono','cargo','actor']);
            $data['estado'] = $request->boolean('estado', true);
            if ($request->filled('password')) {
                $data['password'] = $request->password;
            }
            $user->update($data);
            $base   = User::ACTOR_ROLE_MAP[$user->actor] ?? [];
            $extras = $request->filled('roles')
                    ? Role::findMany($request->roles)->pluck('name')->toArray()
                    : [];
            $user->syncRoles(array_unique(array_merge($base, $extras)));
            $user->instituciones()->sync($request->input('instituciones', []));
        });
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('usuarios.index')->with('success','Usuario eliminado satisfactoriamente');
    }
}
