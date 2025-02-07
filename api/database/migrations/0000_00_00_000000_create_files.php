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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->string('original_name');
            $table->unsignedBigInteger('extension_id');
            $table->unsignedBigInteger('size');
            $table->unsignedBigInteger('pages')->nullable();
            $table->boolean('enabled')->default(TRUE);
            $table->timestamp('disabled_at')->nullable();
            $table->timestamps();
        });
        
        Schema::create('file_extensions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description');
            $table->boolean('enabled')->default(TRUE);
            $table->timestamp('disabled_at')->nullable();
            $table->timestamps();
        });
        
        Schema::create('download_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('created_by');
            $table->uuid('uuid');
            $table->string('token');
            $table->boolean('revoked')->default(FALSE);
            $table->unsignedInteger('hits')->default(0);
            $table->unsignedBigInteger('ttl');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
        Schema::dropIfExists('file_extensions');
        Schema::dropIfExists('download_tokens');
    }
};
