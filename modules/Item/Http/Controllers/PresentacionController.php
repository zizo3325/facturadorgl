<?php

namespace Modules\Item\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Item\Models\Presentacion;
use Modules\Item\Http\Resources\PresentacionCollection;
use Modules\Item\Http\Resources\CategoryResource;
use Modules\Item\Http\Requests\PresentacionRequest;

class PresentacionController extends Controller
{

    public function index()
    {
        return view('item::presentaciones.index');
    }


    public function columns()
    {
        return [
            'name' => 'Nombre',
        ];
    }

    public function records(Request $request)
    {
        $records = Presentacion::where($request->column, 'like', "%{$request->value}%")
                            ->latest();

        return new PresentacionCollection($records->paginate(config('tenant.items_per_page')));
    }


    public function record($id)
    {
        $record = Presentacion::findOrFail($id);

        return $record;
    }

    public function store(PresentacionRequest $request)
    {
        $id = $request->input('id');
        $presentacion = Presentacion::firstOrNew(['id' => $id]);
        $presentacion->fill($request->all());
        $presentacion->save();


        return [
            'success' => true,
            'message' => ($id)?'Presentación editada con éxito':'Presentación registrada con éxito',
            'data' => $presentacion

        ];

    }

    public function destroy($id)
    {
        try {

            $presentacion = Presentacion::findOrFail($id);
            $presentacion->delete();

            return [
                'success' => true,
                'message' => 'Presentación eliminada con éxito'
            ];

        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false,'message' => "La presentación esta siendo usada por otros registros, no puede eliminar"] : ['success' => false,'message' => "Error inesperado, no se pudo eliminar la categoría"];

        }

    }




}
