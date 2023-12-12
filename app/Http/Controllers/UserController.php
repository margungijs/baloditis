<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->validate([
                'name' => 'required|string|max:50|min:3|unique:users',
                'role' => 'required|integer|in:0,1,2',
                'password' => 'required|string|min:8'
            ]);

            $user = User::create($data);

            return response()->json(['message' => 'Registration successful'], 201);
        } catch (ValidationException $e) {
            $errors = $e->validator->getMessageBag();

            $detailedErrors = [];

            foreach ($errors->getMessages() as $field => $messages) {
                $detailedErrors[] = ['field' => $field, 'message' => $messages[0]];
            }

            return response()->json(['error' => 'Validation failed', 'messages' => $detailedErrors], 422);
        }
    }

    public function getUsers(){
        $users = User::where('role', '!=', 3)->get();

        return response()->json($users, 200);
    }

    public function updateUser(Request $request, $userID){
        try {
            $data = $request->validate([
                'name' => 'required|string|max:50|min:3',
                'role' => 'required|integer|in:0,1,2',
                'password' => 'required|string|min:8'
            ]);

            $user = User::findOrFail($userID);

            if ($user->name !== $data['name']) {
                $request->validate([
                    'name' => 'unique:users|string|max:50|min:3',
                ]);
            }

            $user->update($data);

            return response()->json(['message' => 'Update successful'], 201);
        } catch (ValidationException $e) {
            $errors = $e->validator->getMessageBag();

            $detailedErrors = [];

            foreach ($errors->getMessages() as $field => $messages) {
                $detailedErrors[] = ['field' => $field, 'message' => $messages[0]];
            }

            return response()->json(['error' => 'Validation failed', 'messages' => $detailedErrors], 422);
        }
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
