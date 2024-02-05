<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Traits\ApiResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    use ApiResponse;

    public function show()
    {
        $data = User::selectRaw('users.*')->get();
        return $this->success($data);
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $rules_array = collect(Config::get('boilerplate.user_create.validation_rules'));
            $rule_keys = $rules_array->keys()->toArray();
            $params = $request->only($rule_keys);
            $params['password'] = \Hash::make('welcome');
            $data = User::create($params);
            DB::commit();

            return $this->success($data);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error('Unable to create user: ' . $e->getMessage());
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = User::where('id', $id)->first();

            if ($data) {
                $rules_array = collect(Config::get('boilerplate.user_update.validation_rules'));
                $rule_keys = $rules_array->keys()->toArray();

                $params = $request->only($rule_keys);

                $data->fill($params);

                if ($data->update()) {
                    DB::commit();
                    return $this->success($data);
                } else {
                    return $this->error('Unable to update user.');
                }
            } else {
                return $this->error('User not found');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error('Unable to create user: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $data = User::find($id);
        if (!$data) {
            throw new HttpException(404, 'Cannot find user.');
        }

        if ($data->delete()) {
            return $this->success(["message" => "User deleted successfully."]);
        } else {
            throw new HttpException(400, 'Failed to delete user.');
        }
    }
}
