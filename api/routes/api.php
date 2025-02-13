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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebSocketController;

Route::post('websocket/auth', [WebSocketController::class, 'auth']);
Route::get('users/list', [UserController::class, 'users_list']);

Route::group(['middleware' => ['auth:api', 'userlog']], function () {
    Route::get('clients', [ClientController::class, 'browse'])->middleware('role:admin,super,user');
    Route::put('clients/{id}/name', [ClientController::class, 'update_name'])->middleware('role:admin,super,user');
    Route::get('clients/{id}', [ClientController::class, 'read'])->middleware('role:admin,super,user');
    Route::put('clients/{id}', [ClientController::class, 'edit'])->middleware('role:admin,super,user');
    Route::post('clients', [ClientController::class, 'add'])->middleware('role:admin,super,user');
    Route::delete('clients/{id}', [ClientController::class, 'delete'])->middleware('role:admin,super,user');
    Route::get('files/{uuid}/token', [FileController::class, 'generate_download_token']);
    Route::post('files', [FileController::class, 'create'])->middleware('role:admin,super,user');
    Route::delete('files/{id}', [FileController::class, 'delete'])->middleware('role:admin,super,user');
    Route::put('files/{id}/name', [FileController::class, 'update_name'])->middleware('role:admin,super,user');
    Route::put('files/{id}', [FileController::class, 'update'])->middleware('role:admin,super,user');
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('settings', [SettingController::class, 'browse'])->middleware('role:admin');
    Route::put('settings/{id}', [SettingController::class, 'edit'])->middleware('role:admin');
    Route::get('tasks', [TaskController::class, 'browse'])->middleware('role:admin,super,user');
    Route::get('tasks/{id}', [TaskController::class, 'read'])->middleware('role:admin,super,user');
    Route::put('tasks/{id}', [TaskController::class, 'edit'])->middleware('role:admin,super,user');
    Route::post('tasks', [TaskController::class, 'add'])->middleware('role:admin,super,user');
    Route::delete('tasks/{id}', [TaskController::class, 'delete'])->middleware('role:admin,super,user');
    Route::get('tasks/statuses', [TaskController::class, 'read_statuses'])->middleware('role:admin,super,user');
    Route::get('tasks/priorities', [TaskController::class, 'read_priorities'])->middleware('role:admin,super,user');
    Route::get('tasks/{id}/archive', [TaskController::class, 'archive'])->middleware('role:admin,super,user');
    Route::put('tasks/{id}/title', [TaskController::class, 'update_title'])->middleware('role:admin,super,user');
    Route::put('tasks/{id}/delivery_date', [TaskController::class, 'update_delivery_date'])->middleware('role:admin,super,user');
    Route::put('tasks/{id}/client', [TaskController::class, 'update_client'])->middleware('role:admin,super,user');
    Route::put('tasks/{id}/product', [TaskController::class, 'update_product'])->middleware('role:admin,super,user');
    Route::put('tasks/{id}/units', [TaskController::class, 'update_units'])->middleware('role:admin,super,user');
    Route::put('tasks/{id}/status/{status_id}', [TaskController::class, 'update_status'])->middleware('role:admin,super,user');
    Route::put('tasks/{id}/delivery_time/{delivery_time_id}', [TaskController::class, 'update_delivery_time'])->middleware('role:admin,super,user');
    Route::get('user', [UserController::class, 'single']);
    Route::get('users', [UserController::class, 'browse'])->middleware('role:admin');
    Route::get('users/{id}', [UserController::class, 'read'])->middleware('role:admin');
    Route::get('users/{id}/block', [UserController::class, 'block'])->middleware('role:admin');
    Route::get('users/{id}/unblock', [UserController::class, 'unblock'])->middleware('role:admin');
    Route::get('users/{id}/roles', [UserController::class, 'roles'])->middleware('role:admin');
    Route::put('users/{id}/roles', [UserController::class, 'update_roles'])->middleware('role:admin');
    Route::put('users/{id}/name', [UserController::class, 'update_name'])->middleware('role:admin');
    Route::put('users/{id}/email', [UserController::class, 'update_email'])->middleware('role:admin');
    Route::put('users/{id}/password', [UserController::class, 'password'])->middleware('role:admin');
    Route::put('users/{id}', [UserController::class, 'edit'])->middleware('role:admin');
    Route::post('users', [UserController::class, 'add'])->middleware('role:admin');
    Route::delete('users/{id}', [UserController::class, 'delete'])->middleware('role:admin');
    Route::get('user_logs', [UserController::class, 'logs'])->middleware('role:admin,super');
});