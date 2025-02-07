<?php
/*
ETK - Eniwer Training Kit
Copyright (C) 2025 Felipe Andrés Solís Albanese

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class WebSocketController extends Controller
{
    public function auth(Request $request)
    {
        if (!$request->filled('token')) return response()->json(['message' => 'Missing "token"'], 400);
        $user = User::where('websocket_token', $request->token)->first();
        if (!isset($user->id)) return response()->json(['message' => 'Invalid'], 404);
        return response()->json([ 'user' => $user ], 200);
    }
}
