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

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Setting extends Model
{
    use HasUuids;

    protected $table = 'settings';
    
    protected $fillable = [
        'id',
        'name',
        'description',
        'value',
        'locked',
        'revision',
        'enabled',
        'disabled_at',
    ];

    protected $appends = [ 'updated' ];

    protected $casts = [ 'value' => 'array' ];
    
    public function getUpdatedAttribute() {
        $ts = Carbon::parse($this->updated_at);
        return $ts->format('Y-m-d / H:i:s');
    }
}
