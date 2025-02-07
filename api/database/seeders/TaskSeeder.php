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
use App\Models\TaskStatus;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [ 'name' => 'Backlog', 'description' => NULL ],
            [ 'name' => 'Planificada', 'description' => NULL ],
            [ 'name' => 'En Curso', 'description' => NULL ],
            [ 'name' => 'Detenida', 'description' => NULL ],
            [ 'name' => 'En Revisión', 'description' => NULL ],
            [ 'name' => 'Completada', 'description' => NULL ],
            [ 'name' => 'Anulada', 'description' => NULL ],
        ];
        foreach ($items as $i) { TaskStatus::create($i); }
    }
}
