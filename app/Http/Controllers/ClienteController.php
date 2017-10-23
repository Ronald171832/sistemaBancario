<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Cliente;
use Illuminate\Http\Request;
use Session;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $cliente = Cliente::where('nombre', 'LIKE', "%$keyword%")
				->orWhere('paterno', 'LIKE', "%$keyword%")
				->orWhere('materno', 'LIKE', "%$keyword%")
				->orWhere('ci', 'LIKE', "%$keyword%")
				->orWhere('fecha_nacimiento', 'LIKE', "%$keyword%")
				->orWhere('genero', 'LIKE', "%$keyword%")
				->orWhere('correo', 'LIKE', "%$keyword%")
				->orWhere('telefono', 'LIKE', "%$keyword%")
				->orWhere('id_banco', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $cliente = Cliente::paginate($perPage);
        }

        return view('cliente.index', compact('cliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'nombre' => 'required',
			'paterno' => 'required',
			'materno' => 'required',
			'ci' => 'required',
			'fecha_nacimiento' => 'required',
			'genero' => 'required',
			'correo' => 'required',
			'telefono' => 'required',
			'id_banco' => 'required'
		]);
        $requestData = $request->all();
        
        Cliente::create($requestData);

        Session::flash('flash_message', 'Cliente added!');

        return redirect('cliente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
			'nombre' => 'required',
			'paterno' => 'required',
			'materno' => 'required',
			'ci' => 'required',
			'fecha_nacimiento' => 'required',
			'genero' => 'required',
			'correo' => 'required',
			'telefono' => 'required',
			'id_banco' => 'required'
		]);
        $requestData = $request->all();
        
        $cliente = Cliente::findOrFail($id);
        $cliente->update($requestData);

        Session::flash('flash_message', 'Cliente updated!');

        return redirect('cliente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Cliente::destroy($id);

        Session::flash('flash_message', 'Cliente deleted!');

        return redirect('cliente');
    }
}
