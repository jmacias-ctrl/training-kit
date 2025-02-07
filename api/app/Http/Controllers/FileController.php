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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\DownloadToken;
use App\Models\File;
use App\Models\FileExtension;
use App\Models\Setting;

class FileController extends Controller
{
    public function generate_download_token(Request $request, $uuid = NULL)
    {
        if (is_null($uuid)) return response()->json(['message' => 'Missing "uuid"' ], 400);
        $file = File::where('enabled', TRUE)->where('uuid', $uuid)->first();
        if (!isset($file->id)) return response()->json(['message' => 'Not found' ], 404);
        $ttl_setting = Setting::where('enabled', TRUE)->where('name', 'download_token_ttl')->orderBy('revision', 'DESC')->first();
        $ttl = isset($ttl_setting->id) ? $ttl_setting->value->data : 60 * 15;
        $token = Str::random(50);
        $download_token = DownloadToken::create([
            'file_id' => $file->id,
            'uuid' => $file->uuid,
            'token' => $token,
            'ttl' => $ttl,
            'created_by' => $request->user()->id,
        ]);
        $download_token->file->extension;
        return response()->json($download_token, 200);
    }

    public function read_with_download_token(Request $request, $uuid = NULL, $token = NULL)
    {
        if (is_null($uuid)) return response()->json(['message' => 'Missing "uuid"' ], 400);
        if (is_null($uuid)) return response()->json(['message' => 'Missing "token"' ], 400);
        $download_token = DownloadToken::where('uuid', $uuid)->where('token', $token)->first();
        if (!isset($download_token)) return response()->json(['message' => 'Not found' ], 404);
        $download_token->hits++;
        $download_token->save();
        if ($download_token->revoked) return response()->json(['message' => 'Revoked' ], 403);
        $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $download_token->created_at, config('app.timezone'));
        if ($created_at->diffInSeconds(Carbon::now()) > intval($download_token->ttl)) {
            $download_token->revoked = TRUE;
            $download_token->save();
            return response()->json(['message' => 'Expired' ], 403);
        }
        else {
            return Storage::disk('exports')->download($download_token->file->uuid, implode('.', [$download_token->file->name, $download_token->file->extension->name]));
        }
    }

    public function create(Request $request)
    {
        if (!$request->file) return response()->json(['message' => 'Missing "file"' ], 400);
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $filename = pathinfo($name, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $file_extension = FileExtension::where('name', strtolower($extension))->first();
        if (!isset($file_extension->id)) return response()->json(['message' => 'Not allowed.'], 400);
        if ($size > 10 * 1024 * 1024) return response()->json(['message' => 'Filesize too big'], 400);
        $uuid = Str::uuid();
        Storage::putFileAs('imports', $file, $uuid);
        $file = File::create([
            'uuid' => $uuid,
            'name' => $filename,
            'original_name' => $filename,
            'extension_id' => $file_extension->id,
            'size' => $size,
            'pages' => isset($pages) ? $pages : NULL,
        ]);
        $file->extension;
        return response()->json($file);
    }

    public function delete(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        $file = File::find($id);
        if (!isset($file->id)) return response()->json(['message' => 'Resource not found.'], 404);
        if (!$file->enabled) return response()->json(['message' => 'Resource gone.'], 410);
        $file->enabled = FALSE;
        $file->disabled_at = now();
        $file->save();
        return response()->json(['message' => 'Resource deleted.'], 200);
    }

    public function update_name(Request $request, $id = NULL)
    {
        if (is_null($id)) return response()->json(['message' => 'Missing "id"'], 400);
        if (!$request->filled('name')) return response()->json(['message' => 'Missing "name"'], 400);
        $resource = File::where('enabled', TRUE)->where('id', $id)->first();
        if (!isset($resource->id)) return response()->json(['message' => 'Not found'], 404);
        try {
            $resource->name = $request->name;
            $resource->save();
            $resource->extension;
            return response()->json($resource, 200);
        }
        catch(Exception $error) {
            return response()->json(['message' => 'Internal error', 'details' => $error ], 500);
        }
    }
}
