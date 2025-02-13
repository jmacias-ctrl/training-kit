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

export default {
	system(state) {
		return state.system;
	},
	websocket(state) {
		return state.session.websocket;
	},
	session(state) {
		return state.session;
	},
	users(state) {
		return state.users;
	},
	users_online(state) {
		return state.users_online;
	},
	users_list(state) {
		return state.users_list;
	},
	user_logs(state) {
		return state.user_logs;
	},
	settings(state) {
		return state.settings;
	},
	archived(state) {
		return state.archived;
	},
	tasks(state) {
		return state.tasks;
	},
	clients(state) {
		return state.clients;
	},
	task_statuses(state) {
		return state.task_statuses;
	},
	modals(state) {
		return state.modals;
	},
}