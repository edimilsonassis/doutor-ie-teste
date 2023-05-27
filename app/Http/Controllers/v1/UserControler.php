<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Response;

use App\Models\v1\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;
use App\Http\Requests\v1\{StoreUserRequest, UpdateUserRequest};

class UserControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(
            User::paginate(5)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::factory()->create($data);

        return $user;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find((int) $id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find((int) $id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        $data = $request->validated();

        return !$user->update($data) ?: response(null, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find((int) $id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        return !$user->delete() ?: response(null, Response::HTTP_NO_CONTENT);
    }
}