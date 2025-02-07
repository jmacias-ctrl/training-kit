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
	system: {
		build: import.meta.env.VITE_BUILD,
		api: {
			path: import.meta.env.VITE_API_PATH,
			client_id: import.meta.env.VITE_API_CLIENT_ID,
			client_secret: import.meta.env.VITE_API_CLIENT_SECRET,
		},
		time: {
			hour: null,
			minute: null,
			second: null,
		},
		settings: {
			screen: {
				width: 0,
				height: 0,
				fluid: null
			},
			ui: {
				size: 'md',
				theme: 'light'
			}
		},
	},
	archived: false,
	session: {
		loading: true,
		credentials: {
			username: null,
			password: null,
		},
		user: {
			loading: true,
			id: null,
			name: null,
			email: null,
		},
		privileges: {
			loading: true,
			data: null,
		},
		api: {
			loading: true,
			active: false,
			access_token: localStorage.getItem('access_token') || null,
			refresh_token: localStorage.getItem('refresh_token') || null,
		},
		websocket: {
			loading: true,
			online: false,
			token: localStorage.getItem('websocket_token') || null,
			socket: null,
		},
	},
	users: {
		loading: false,
		items: [],
	},
	user_logs: {
		browser: {
			limit: 10,
			page: 1,
		},
		loading: false,
		items: {},
	},
	settings: {
		browser: {
			limit: 25,
			page: 1,
		},
		loading: false,
		items: [],
	},
	tasks: {
		loading: false,
		items: [],
	},
	clients: {
		loading: false,
		items: [],
	},
	modals: {
		AddUserModal: null,
		BlockUserModal: null,
		ChangeUserPasswordModal: null,
		ChangeUserRoleModal: null,
		DeleteUserModal: null,
		UnblockUserModal: null,
		AddTaskModal: null,
		DeleteTaskModal: null,
		ArchiveTaskModal: null,
		AddClientModal: null,
		user_roles: {
			loading: false,
			items: {
				user: null,
				super: null,
				admin: null,
			},
		},
	},
}