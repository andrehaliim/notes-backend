<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use App\Area;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Illuminate\Http\Request;
use App\Api\V1\Requests\AreaRequest;
use App\Api\V1\Requests\AreaUpdateRequest;
use App\Exports\AreaExport;
use App\Http\Requests\NotesRequest;
use App\Models\Notes;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NotesController extends Controller
{
    protected function createResponse($param = array())
    {
        $status = !empty($param['status']) ? $param['status'] : 200;
        $message = !empty($param['message']) ? $param['message'] : 'OK';
        $data = !empty($param['data']) ? $param['data'] : [];

        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }

    public function show()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $query = Notes::selectRaw('notes.*');

        $qb = QueryBuilder::for($query)->allowedSorts(
            [
            ])
            ->allowedFilters(
            [
            ])->distinct();

        
        $data = $qb->get();

        return response()->json($this->createResponse(['data' => $data]), 200);
    }

    public function store(NotesRequest $request)
    {
        $rules_array = collect(Config::get('boilerplate.notes_create.validation_rules'));
        $rule_keys = $rules_array->keys()->toArray();

        $data = Notes::create($request->only($rule_keys));
        return response()->json($this->createResponse(['data' => $data->id]), 200);
    }

    public function update(NotesRequest $request, $id)
    {
        $data = Notes::find($id);

        if ($data) {
            $rules_array = collect(Config::get('boilerplate.notes_update.validation_rules'));
            $rule_keys = $rules_array->keys()->toArray();
            $data->fill($request->only($rule_keys));

            if ($data->update()) {
                return response()->json($this->createResponse(["message" => "Note updated successfully."]), 200);
            } else {
                throw new HttpException(400, 'Failed to update note.');
            }
        } else {
            throw new HttpException(404, 'Cannot find note.');
        }
    }

    public function delete($id)
    {
        $data = Notes::find($id);
        if (!$data) {
            throw new HttpException(404, 'Cannot find note.');
        }

        if ($data->delete()) {
            return response()->json($this->createResponse(["message" => "Note deleted successfully."]), 200);
        } else {
            throw new HttpException(400, 'Failed to delete note.');
        }
    }

    /*public function showById($id)
    {
        $data = Area::find($id);
        if ($data) {
            return response()->json($this->createResponse(['data' => $data]), 200);
        } else {
            throw new HttpException(404, 'Area tidak ditemukan.');
        }
    }*/
}
