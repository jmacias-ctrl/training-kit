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

import api from '@/api.js'

export default {
	login(context) {
		return new Promise((resolve, reject) => {
			api.post('oauth/token', {
				username: context.state.session.credentials.username,
				password: context.state.session.credentials.password,
				grant_type: 'password',
				client_id: context.state.system.api.client_id,
				client_secret: context.state.system.api.client_secret,
			})
			.then(response => {
				context.commit('clear_login');
				context.commit('access_token', response.data.access_token);
				context.commit('refresh_token', response.data.refresh_token);
				api.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token;
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},
	
	saveSocket(context, params) {
		context.commit('save_socket', { socket: params.socket });
	},

	user(context) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.get('api/user')
			.then(response => {
				context.commit('save_websocket_token', { token: response.data.websocket_token });
				const socket = context.state.session.websocket.socket;
				if(!socket?.connected) {
					socket.auth = { token: response.data.websocket_token };
					socket.connect();
				}
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	refresh(context) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.post('oauth/token', {
				grant_type: 'refresh_token',
				refresh_token: context.state.session.api.refresh_token,
				client_id: context.state.system.api.client_id,
				client_secret: context.state.system.api.client_secret,
			})
			.then(response => {
				context.commit('access_token', response.data.access_token);
				context.commit('refresh_token', response.data.refresh_token);
				api.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token;
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	logout(context) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.post('api/logout', {
				access_token: context.state.session.api.access_token
			})
			.then(response => {
				context.commit('clear_session');
				resolve(response);
			})
			.catch(error => {
				context.commit('clear_session');
				reject(error);
			});
		});
	},

	tasks(context) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		context.state.tasks.loading = true;
		return new Promise((resolve, reject) => {
			api.get('api/tasks', {
				params: {
					archived: context.state.archived
				}
			})
			.then(response => {
				context.commit('tasks', response.data);
				context.state.tasks.loading = false;
				resolve(response);
			})
			.catch(error => {
				context.state.tasks.loading = false;
				reject(error);
			});
		});
	},

	users(context) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		context.state.users.loading = true;
		return new Promise((resolve, reject) => {
			api.get('api/users')
			.then(response => {
				context.commit('users', response.data)
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	user_logs(context) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		context.state.user_logs.loading = true;
		return new Promise((resolve, reject) => {
			api.get('api/user_logs', {
				params: {
					limit: context.state.user_logs.browser.limit,
					page: context.state.user_logs.browser.page,
				}
			})
			.then(response => {
				context.commit('user_logs', response.data)
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	settings(context) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		context.state.settings.loading = true;
		return new Promise((resolve, reject) => {
			api.get('api/settings', {
				params: {
					limit: context.state.settings.browser.limit,
					page: context.state.settings.browser.page,
				}
			})
			.then(response => {
				context.commit('settings', response.data)
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	update_setting(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/settings/'+data.setting_id, {
				value: data.value,
				type: data.type,
			})
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	add_task(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.post('api/tasks', data)
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	add_user(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.post('api/users', data)
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	delete_task(context, task_id) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.delete('api/tasks/'+task_id)
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	archive_task(context, task_id) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.get('api/tasks/'+task_id+'/archive')
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	delete_user(context, user_id) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.delete('api/users/'+user_id)
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	block_user(context, user_id) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.get('api/users/'+user_id+'/block')
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	unblock_user(context, user_id) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.get('api/users/'+user_id+'/unblock')
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	change_user_password(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/users/'+data.user_id+'/password', {
				password: data.password
			})
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	user_roles(context, user_id) {
		context.state.modals.user_roles.loading = true;
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.get('api/users/'+user_id+'/roles')
			.then(response => {
				context.commit('user_roles', response.data);
				resolve(response);
			})
			.catch(error => {
				context.state.modals.user_roles.loading = false;
				reject(error);
			});
		});
	},

	change_user_roles(context, user_id) {
		context.state.modals.user_roles.loading = true;
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/users/'+user_id+'/roles', context.getters.modals.user_roles.items)
			.then(response => {
				context.commit('user_roles', response.data);
				resolve(response);
			})
			.catch(error => {
				context.state.modals.user_roles.loading = false;
				reject(error);
			});
		});
	},

	change_user_name(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/users/'+data.user_id+'/name', {
				name: data.name
			})
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	change_user_email(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/users/'+data.user_id+'/email', {
				email: data.email
			})
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	update_task_status(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/tasks/'+data.task_id+'/status/'+data.status_id)
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	update_task_units(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/tasks/'+data.task_id+'/units', {
				units: data.units
			})
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	update_task_title(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/tasks/'+data.task_id+'/title', {
				title: data.title
			})
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	update_task_delivery_date(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/tasks/'+data.task_id+'/delivery_date', {
				delivery_date: data.delivery_date
			})
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	update_task_client(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.put('api/tasks/'+data.task_id+'/client', {
				client_id: data.client_id
			})
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

	clients(context) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		context.state.clients.loading = true;
		return new Promise((resolve, reject) => {
			api.get('api/clients')
			.then(response => {
				context.commit('clients', response.data)
				context.state.clients.loading = false;
				resolve(response);
			})
			.catch(error => {
				context.state.clients.loading = false;
				reject(error);
			});
		});
	},

	add_client(context, data) {
		api.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.session.api.access_token;
		return new Promise((resolve, reject) => {
			api.post('api/clients', data)
			.then(response => {
				resolve(response);
			})
			.catch(error => {
				reject(error);
			});
		});
	},

}