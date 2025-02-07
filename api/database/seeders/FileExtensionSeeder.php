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
use App\Models\FileExtension;

class FileExtensionSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [ 'name' => NULL, 'description' => 'Archivo Sin Formato' ],
            [ 'name' => 'pdf', 'description' => 'Documento PDF' ],
            [ 'name' => 'txt', 'description' => 'Documento de Texto' ],
            [ 'name' => 'jpg', 'description' => 'Imagen JPG' ],
            [ 'name' => 'jpeg', 'description' => 'Imagen JPEG' ],
            [ 'name' => 'gif', 'description' => 'Imagen GIF' ],
            [ 'name' => 'png', 'description' => 'Imagen PNG' ],
            [ 'name' => 'docx', 'description' => 'Documento Word' ],
            [ 'name' => 'doc', 'description' => 'Documento Word (97-2003)' ],
            [ 'name' => 'xlsx', 'description' => 'Libro Excel' ],
            [ 'name' => 'xls', 'description' => 'Libro Excel (97-2003)' ],
            [ 'name' => 'pptx', 'description' => 'Presentación PowerPoint' ],
            [ 'name' => 'ppt', 'description' => 'Presentación PowerPoint (97-2003)' ],
            [ 'name' => 'zip', 'description' => 'Archivo Comprimido ZIP' ],
            [ 'name' => 'rar', 'description' => 'Archivo Comprimido RAR' ],
            [ 'name' => '7z', 'description' => 'Archivo Comprimido 7-Zip' ],
            [ 'name' => 'exe', 'description' => 'Aplicación Ejecutable' ],
            [ 'name' => 'msi', 'description' => 'Paquete de Windows Installer' ],
            [ 'name' => 'mp4', 'description' => 'Archivo de Video MP4' ],
            [ 'name' => 'mpg', 'description' => 'Archivo de Video MPG' ],
            [ 'name' => 'mpeg', 'description' => 'Archivo de Video MPEG' ],
            [ 'name' => '3gp', 'description' => 'Archivo de Video 3GP' ],
            [ 'name' => 'mkv', 'description' => 'Archivo de Video MKV' ],
            [ 'name' => 'flv', 'description' => 'Archivo de Video FLV' ],
            [ 'name' => 'avi', 'description' => 'Archivo de Video AVI' ],
            [ 'name' => 'mov', 'description' => 'Archivo de Video MOV' ],
            [ 'name' => 'mp3', 'description' => 'Archivo de Sonido MP3' ],
            [ 'name' => 'ogg', 'description' => 'Archivo de Sonido OGG' ],
            [ 'name' => 'wav', 'description' => 'Archivo de Sonido WAV' ],
            [ 'name' => 'm4a', 'description' => 'Archivo de Sonido M4A' ],
            [ 'name' => 'aac', 'description' => 'Archivo de Sonido AAC' ],
        ];
        foreach ($items as $i) { FileExtension::create($i); }
    }
}
