<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepositoryRequest;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{

    public function index(){
        return view('repositories.index',[
            'repositories' => auth()->user()->repositories
        ]);
    }

    public function show(Repository $repository){
        $this->authorize('pass', $repository);
        return view('repositories.show', compact('repository'));
    }

    public function edit(Repository $repository){
        if (auth()->user()->id != $repository->user_id) {
            abort(403);
        }
        return view('repositories.show', compact('repository'));
    }

    public function create(){
        return view('repositories.create');
    }

    public function store(RepositoryRequest $request){
        // $request->validate([ //Validamos de que estos campos estén.
        //     'url'=>'required',
        //     'description'=>'required',
        // ]);
        $request->user()->repositories()->create($request->all());
        return redirect()->route('repositories.index');
    }

    public function update(Repository $repository, RepositoryRequest $request){
        
        $this->authorize('pass', $repository);

        $repository->update($request->all());
        $repository->save();
        return redirect()->route('repositories.edit', $repository);
    }

    public function destroy(Repository $repository){

        $this->authorize('pass', $repository); //Esto reemplaza la condicional de abajo.

        // if ($request->user()->id != $repository->user_id) {
        //     ///Tambien se puede realizar el siguiente comando.
        //     abort(403);
        //     //El que me aprendí de los cursos para retornar un codigo http con json
        //     // return response()->json([
        //     //     'message'=>'Accion invalida.'
        //     // ], 403);
        //
        //}
        $repository->delete();
        return redirect()->route('repositories.index');
    }
}
