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

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserLog;
use Auth;

class LogUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (isset($user->id)) {
            $user->last_seen = now();
            $user->save();
            UserLog::create([
                'user_id' => $user->id,
                'path' => $request->path(),
                'method' => $request->getMethod(),
                'body' => json_encode($request->all()),
                'ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);
        }
        return $next($request);
    }
}