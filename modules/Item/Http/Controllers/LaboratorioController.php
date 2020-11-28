<?php

namespace Modules\Item\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Item\Models\Laboratorio;
use Modules\Item\Http\Resources\LaboratorioCollection;
use Modules\Item\Http\Resources\CategoryResource;
use Modules\Item\Http\Requests\LaboratorioRequest;

class LaboratorioController extends Controller
{

    public function index()
    {
        return view('item::laboratorios.index');
    }


    public function columns()
    {
        return [
            'name' => 'Nombre',
        ];
    }

    public function records(Request $request)
    {
        $records = Laboratorio::where($request->column, 'like', "%{$request->value}%")
                            ->latest();

        return new LaboratorioCollection($records->paginate(config('tenant.items_per_page')));
    }


    public function record($id)
    {
        $record = Laboratorio::findOrFail($id);

        return $record;
    }

    public function store(LaboratorioRequest $request)
    {
        $id = $request->input('id');
        $laboratorio = Laboratorio::firstOrNew(['id' => $id]);
        $laboratorio->fill($request->all());
        $laboratorio->save();


        return [
            'success' => true,
            'message' => ($id)?'Laboratorio editado con éxito':'Laboratorio registrado con éxito',
            'data' => $laboratorio

        ];

    }

    public function destroy($id)
    {
        try {

            $laboratorio = Laboratorio::findOrFail($id);
            $laboratorio->delete();

            return [
                'success' => true,
                'message' => 'Laboratorio eliminado con éxito'
            ];

        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false,'message' => "El laboratorio esta siendo usada por otros registros, no puede eliminar"] : ['success' => false,'message' => "Error inesperado, no se pudo eliminar el laboratorio"];

        }

    }




}
