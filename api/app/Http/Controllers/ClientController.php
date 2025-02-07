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
use App\Models\Client;

class ClientController extends Controller
{
    public function browse(Request $request)
    {
        $resources = Client::where('enabled', TRUE)->orderBy('id', 'ASC')->get();
        if (!count($resources)) return response()->json(['message' => 'No records'], 404);
        return response()->json($resources, 200);
    }

    public function read(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $resource = Client::where('enabled', TRUE)->find($id);
        if (!isset($resource->id)) return response()->json(['message' => 'Not found'], 404);
        return response()->json($resource, 200);
    }

    public function edit(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $resource = Client::find($id);
        if (!isset($resource->id)) return response()->json(['message' => 'Not found'], 404);
        if ($resource->name != $request->name) $duplicated = Client::where('name', $request->name)->first();
        if (isset($duplicated) && isset($duplicated->id)) return response()->json(['message' => 'Duplicated'], 409);
        $resource->name = $request->name;
        $resource->save();
        return response()->json($resource, 200);
    }

    public function add(Request $request)
    {
        if (!$request->filled('name')) return response()->json(['message' => 'Missing "name"'], 400);
        $duplicated = Client::where('name', $request->name)->first();
        if (isset($duplicated->id)) return response()->json(['message' => 'Duplicated "name"'], 409);
        $resource = new Client;
        $resource->name = $request->name;
        if ($request->filled('phone')) $resource->phone = $request->phone;
        if ($request->filled('email')) $resource->email = $request->email;
        $resource->save();
        return response()->json($resource, 200);
    }

    public function delete(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $resource = Client::find($id);
        if (!isset($resource->id)) return response()->json(['message' => 'Not found'], 404);
        if ($resource->enabled === FALSE) return response()->json(['message' => 'Gone'], 410);
        $resource->enabled = FALSE;
        $resource->disabled_at = now();
        $resource->save();
        return response()->json($resource, 200);
    }

    public function update_name(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $resource = Client::find($id);
        if (!isset($resource->id)) return response()->json(['message' => 'Not found'], 404);
        if (!$request->filled('name')) return response()->json(['message' => 'Missing "name"'], 404);
        $resource->name = $request->name;
        $resource->save();
        return response()->json($resource, 200);
    }
}
