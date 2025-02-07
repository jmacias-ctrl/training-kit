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
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [ 'code' => 'AP', 'name' => 'Arica y Parinacota' ],
            [ 'code' => 'TA', 'name' => 'Tarapacá' ],
            [ 'code' => 'AN', 'name' => 'Antofagasta' ],
            [ 'code' => 'AT', 'name' => 'Atacama' ],
            [ 'code' => 'CO', 'name' => 'Coquimbo' ],
            [ 'code' => 'VA', 'name' => 'Valparaíso' ],
            [ 'code' => 'LI', 'name' => "Lib. Gral. Bernardo O'Higgins" ],
            [ 'code' => 'ML', 'name' => 'Maule' ],
            [ 'code' => 'NB', 'name' => 'Ñuble' ],
            [ 'code' => 'BI', 'name' => 'Biobío' ],
            [ 'code' => 'AR', 'name' => 'La Araucanía' ],
            [ 'code' => 'LR', 'name' => 'Los Ríos' ],
            [ 'code' => 'LL', 'name' => 'Los Lagos' ],
            [ 'code' => 'AI', 'name' => 'Aysén del Gral. C. Ibáñez del Campo' ],
            [ 'code' => 'MA', 'name' => 'Magallanes y Antártica Chilena' ],
            [ 'code' => 'RM', 'name' => 'Metropolitana de Santiago' ],
        ];
        foreach($items as $i) { Region::create($i); }
    }
}
