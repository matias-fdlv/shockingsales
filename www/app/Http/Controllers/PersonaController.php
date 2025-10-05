<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Services\Users\UserDataService;
use Illuminate\Http\Request;

class PersonaController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personas = Persona::has('usuario')
            ->with('usuario') 
            ->latest()
            ->paginate(5);

        return view('personas.index', compact('personas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('personas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Estado' => 'nullable|string',
            'Nombre' => 'required',
            'Mail' => 'required',
            'Contraseña' => 'required',
            'SecretKey' => 'nullable|string'
        ]);

        Persona::create($request->all());

        return redirect()->route('personas.index')->with('success', 'Persona creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Persona $persona)
    {
        return view('personas.edit', compact('persona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'Estado' => 'nullable|string',
            'Nombre' => 'required',
            'Mail' => 'required',
            'Contraseña' => 'required',
            'SecretKey' => 'nullable|string'
        ]);

        $persona->update($request->all());

        return redirect()->route('personas.index')->with('success', 'Persona actualizado correctamente.');
    }

    public function activarCuenta(Request $request, UserDataService $service)
    {
        $data = $request->validate(['Mail' => ['required', 'email']]);
        $service->activarUsuario(mail: $data['Mail']);
        return back();
    }

    public function desactivarCuenta(Request $request, UserDataService $service)
    {
        $data = $request->validate(['Mail' => ['required', 'email']]);
        $service->desactivarUsuario(mail: $data['Mail']);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();
        return redirect()->route('personas.index')->with('success', 'Persona eliminado correctamente.');
    }
}
