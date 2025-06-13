<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'senha_atual' => 'required',
            'nova_senha' => 'required|min:6|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->senha_atual, $user->password)) {
            return response()->json(['message' => 'Senha atual incorreta.'], 422);
        }

        $user->update([
            'password' => Hash::make($request->nova_senha)
        ]);

        return response()->json(['message' => 'Senha alterada com sucesso.']);
    }
}

