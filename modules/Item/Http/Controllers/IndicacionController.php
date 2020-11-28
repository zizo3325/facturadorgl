<?php

namespace Modules\Item\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Item\Models\Indicacion;
use Modules\Item\Http\Resources\IndicacionCollection;
use Modules\Item\Http\Resources\IndicacionResource;
use Modules\Item\Http\Requests\IndicacionRequest;

class IndicacionController extends Controller
{

    public function index()
    {
        return view('item::indicaciones.index');
    }


    public function columns()
    {
        return [
            'name' => 'Nombre',
        ];
    }

    public function records(Request $request)
    {
        $records = Indicacion::where($request->column, 'like', "%{$request->value}%")
                            ->latest();

        return new IndicacionCollection($records->paginate(config('tenant.items_per_page')));
    }


    public function record($id)
    {
        $record = Indicacion::findOrFail($id);

        return $record;
    }

    public function store(IndicacionRequest $request)
    {
        $id = $request->input('id');
        $indicacion = Indicacion::firstOrNew(['id' => $id]);
        $indicacion->fill($request->all());
        $indicacion->save();


        return [
            'success' => true,
            'message' => ($id)?'Indicación editada con éxito':'Indicación registrada con éxito',
            'data' => $indicacion

        ];

    }

    public function destroy($id)
    {
        try {

            $indicacion = Indicacion::findOrFail($id);
            $indicacion->delete();

            return [
                'success' => true,
                'message' => 'Indicación eliminada con éxito'
            ];

        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false,'message' => "La indicación esta siendo usada por otros registros, no puede eliminar"] : ['success' => false,'message' => "Error inesperado, no se pudo eliminar la categoría"];

        }

    }




}
