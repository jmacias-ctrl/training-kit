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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use App\Mail\NewUser;
use App\Models\UserRole;
use App\Models\UserLog;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function browse(Request $request)
    {
        $items = User::where('enabled', TRUE)->with('roles')->get();
        if (!count($items)) return response()->json(['message' => 'No records'], 404);
        return response()->json($items, 200);
    }

    public function read(Request $request, $id = NULL)
    {
        if (!isset($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $user = User::where('enabled', TRUE)->find($id);
        if (!isset($user->id)) return response()->json(['message' => 'Not found'], 404);
        return response()->json($user, 200);
    }

    public function single(Request $request)
    {
        $user = Auth::user();
        return response()->json($user, 200);
    }

    public function edit(Request $request, $id = NULL)
    {
        if (!isset($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $user = User::find($id);
        if (!isset($user->id)) return response()->json(['message' => 'Not found'], 404);
        if ($user->email != $request->email) $duplicated = User::where('email', $request->email)->first();
        if (isset($duplicated) && isset($duplicated->id)) return response()->json(['message' => 'Duplicated'], 409);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        foreach($request->roles as $role) {
            $roleExists = UserRole::where('user_id', $user->id)->where('role_id', intval($role))->first();
            if (isset($roleExists->id)) {
                if ($roleExists->enabled === FALSE) {
                    $roleExists->enabled = TRUE;
                    $roleExists->save();
                }
            } else {
                UserRole::create([
                    'role_id' => intval($role),
                    'user_id' => $user->id,
                ]);
            }
        }
        return response()->json($user, 200);
    }

    public function add(Request $request)
    {
        if (!$request->filled('name')) return response()->json(['message' => 'Missing "name"'], 400);
        if (!$request->filled('email')) return response()->json(['message' => 'Missing "email"'], 400);
        $duplicated = User::where('email', $request->email)->first();
        if (isset($duplicated->id)) return response()->json(['message' => 'Duplicated'], 409);
        $password = $request->filled('password') ? $request->password : Str::random(10);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'remember_token' => Str::random(10),
            'websocket_token' => Str::random(64),
        ]);
        UserRole::create([
            'role_id' => 1,
            'user_id' => $user->id,
        ]);
        //Mail::to($user->email)->send(new NewUser($user));
        return response()->json($user, 200);
    }

    public function update_roles(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $data = User::find($id);
        if (!isset($data->id)) return response()->json(['message' => 'Not found'], 404);
        if (!$request->filled(['user','super','admin'])) return response()->json(['message' => 'Missing "roles"'], 400);
        $userRole = UserRole::where('user_id', $data->id)->where('role_id', 1)->first();
        if ($request->user === TRUE) {
            if (isset($userRole->id)) {
                if ($userRole->enabled == FALSE) {
                    $userRole->enabled = TRUE;
                    $userRole->save();
                }
            } else {
                UserRole::create([
                    'user_id' => $data->id,
                    'role_id' => 1,
                ]);
            }
        } else {
            if (isset($userRole->id) && $userRole->enabled === TRUE) {
                $userRole->enabled = FALSE;
                $userRole->disabled_at = now();
                $userRole->save();
            }
        }
        $superRole = UserRole::where('user_id', $data->id)->where('role_id', 2)->first();
        if ($request->super === TRUE) {
            if (isset($superRole->id)) {
                if ($superRole->enabled === FALSE) {
                    $superRole->enabled = TRUE;
                    $superRole->save();
                }
            } else {
                UserRole::create([
                    'user_id' => $data->id,
                    'role_id' => 2,
                ]);
            }
        } else {
            if (isset($superRole->id) && $superRole->enabled === TRUE) {
                $superRole->enabled = FALSE;
                $superRole->disabled_at = now();
                $superRole->save();
            }
        }
        $adminRole = UserRole::where('user_id', $data->id)->where('role_id', 3)->first();
        if ($request->admin === TRUE) {
            if (isset($adminRole->id)) {
                if ($adminRole->enabled === FALSE) {
                    $adminRole->enabled = TRUE;
                    $adminRole->save();
                }
            } else {
                UserRole::create([
                    'user_id' => $data->id,
                    'role_id' => 3,
                ]);
            }
        } else {
            if (isset($adminRole->id) && $adminRole->enabled === TRUE) {
                $adminRole->enabled = FALSE;
                $adminRole->disabled_at = now();
                $adminRole->save();
            }
        }
        $user = FALSE;
        $super = FALSE;
        $admin = FALSE;
        foreach($data->roles as $role) {
            if ($role->codename === 'user' && $role->enabled === TRUE) {
                $user = TRUE;
            } else if ($role->codename === 'super' && $role->enabled === TRUE) {
                $super = TRUE;
            } else if ($role->codename === 'admin' && $role->enabled === TRUE) {
                $admin = TRUE;
            }
        }
        return response()->json([
            'user' => $user,
            'super' => $super,
            'admin' => $admin,
        ], 200);
    }

    public function roles(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $data = User::find($id);
        if (!isset($data->id)) return response()->json(['message' => 'Not found'], 404);
        $user = FALSE;
        $super = FALSE;
        $admin = FALSE;
        foreach($data->roles as $role) {
            if ($role->codename === 'user' && $role->enabled === TRUE) $user = TRUE;
            if ($role->codename === 'super' && $role->enabled === TRUE) $super = TRUE;
            if ($role->codename === 'admin' && $role->enabled === TRUE) $admin = TRUE;
        }
        return response()->json([
            'user' => $user,
            'super' => $super,
            'admin' => $admin,
        ], 200);
    }

    public function update_name(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $user = User::find($id);
        if (!isset($user->id)) return response()->json(['message' => 'Not found'], 404);
        if (!$request->filled('name')) return response()->json(['message' => 'Missing "name"'], 404);
        $user->name = $request->name;
        $user->save();
        return response()->json($user, 200);
    }

    public function update_email(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $user = User::find($id);
        if (!isset($user->id)) return response()->json(['message' => 'Not found'], 404);
        if (!$request->filled('email')) return response()->json(['message' => 'Missing "email"'], 404);
        $duplicated = User::where('email', $request->email)->first();
        if (isset($duplicated->id)) return response()->json(['message' => 'Duplicated'], 409);
        $user->email = $request->email;
        $user->save();
        return response()->json($user, 200);
    }

    public function block(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $user = User::find($id);
        if (!isset($user->id)) return response()->json(['message' => 'Not found'], 404);
        $user->blocked = TRUE;
        $user->blocked_at = now();
        $user->save();
        return response()->json($user, 200);
    }

    public function unblock(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $user = User::find($id);
        if (!isset($user->id)) return response()->json(['message' => 'Not found'], 404);
        $user->blocked = FALSE;
        $user->blocked_at = NULL;
        $user->save();
        return response()->json($user, 200);
    }

    public function password(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $user = User::find($id);
        if (!isset($user->id)) return response()->json(['message' => 'Not found'], 404);
        $password = $request->filled('password') ? $request->password : Str::random(10);
        $user->password = Hash::make($password); 
        $user->save();
        return response()->json($user, 200);
    }

    public function delete(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $user = User::find($id);
        if (!isset($user->id)) return response()->json(['message' => 'Not found'], 404);
        if ($user->enabled === FALSE) return response()->json(['message' => 'Gone'], 410);
        $user->enabled = FALSE;
        $user->disabled_at = now();
        $user->save();
        return response()->json($user, 200);
    }

    public function logout(Request $request)
    {
        if (!$request->filled('access_token')) return response()->json(['message' => 'Missing "access_token"'], 400);
        $tokenId = $request->access_token;
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
        return response()->json(['message' => 'Logged out'], 200);
    }

    public function logs(Request $request)
    {
        $items = UserLog::with('user')->orderBy('id', 'DESC')->get();
        if (!count($items)) return response()->json(['message' => 'No records'], 404);
        $currentItems = array_slice($items->toArray(), $request->limit * ($request->page - 1), $request->limit);
        $response = new LengthAwarePaginator($currentItems, count($items), $request->limit, $request->page);
        return response()->json($response, 200);
    }

    public function users_list(Request $request){
        #if (!$request->filled('access_token')) return response()->json(['message' => 'Missing "access_token"'], 400);
        $items = User::where('enabled', TRUE)->select('id', 'name', 'last_seen')->get();
        return response()->json($items, 200);
    }
}