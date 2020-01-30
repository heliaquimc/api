<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController
{
    protected $class;

    public function index(Request $request)
    {
        return response()
            ->json(
                $this->class::paginate($request->per_page),
                200
            );
    }

    public function store(Request $request)
    {
        return response()
            ->json(
                $this->class::create($request->all()),
                201
            );
    }

    public function show(int $id){
        $recurso = $this->class::find($id);
        $status = is_null($recurso) ? 204 : 200;

        return response()->json($recurso, $status);
    }

    public function update(int $id, Request $request){
        $recurso = $this->class::find($id);

        if(is_null($recurso)){
            return response()->json(['erro' => 'Recurso não encontrado'], 404);
        }

        $recurso->fill($request->all());
        $recurso->save();

        return response()->json($recurso);
    }

    public function destroy(int $id){
        $qtdRecursosRemovidos = $this->class::destroy($id);
        if ($qtdRecursosRemovidos === 0) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        return response()->json('', 204);
    }
}
