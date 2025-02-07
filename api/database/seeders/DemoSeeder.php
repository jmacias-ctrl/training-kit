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

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Task;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $items = [[
            'name' => 'Falabella',
            'email' => 'contacto@falabella.cl',
            'phone' => NULL,
        ],[
            'name' => 'Ripley',
            'email' => 'contacto@ripley.cl',
            'phone' => NULL,
        ],[
            'name' => 'Paris',
            'email' => 'contacto@paris.cl',
            'phone' => NULL,
        ]];
        foreach($items as $i) { Client::create($i); }

        $items = [[
            'title' => 'Activar servidor de pruebas',
            'status_id' => 1,
            'delivery_date' => '2025-02-23',
            'comment' => NULL,
            'client_id' => 1,
            'units' => 2
        ],[
            'title' => 'Integrar API de geolocalización',
            'status_id' => 2,
            'delivery_date' => '2025-03-10',
            'comment' => NULL,
            'client_id' => 2,
            'units' => 3
        ],[
            'title' => 'Integrar API de geolocalización',
            'status_id' => 3,
            'delivery_date' => '2025-04-02',
            'comment' => NULL,
            'client_id' => 3,
            'units' => 12
        ]];
        foreach ($items as $i) { Task::create($i); }
    }
}
