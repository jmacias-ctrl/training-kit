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

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'id',
        'title',
        'status_id',
        'delivery_date',
        'comment',
        'client_id',
        'units',
        'created_by',
        'archived',
        'archived_at',
        'enabled',
        'disabled_at',
    ];

    protected $appends = [ 'delivery' ];

    public function getDeliveryAttribute() {
        if (is_null($this->delivery_date)) return NULL;
        $date = Carbon::create($this->delivery_date);
        return $date->format('d/m/Y');
    }

    public function creator() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    
    public function client() {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function status() {
        return $this->hasOne(TaskStatus::class, 'id', 'status_id');
    }
}