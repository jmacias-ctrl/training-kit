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

import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import LogoutView from '@/views/LogoutView.vue'
import UsersView from '@/views/UsersView.vue'
import UsersLogView from '@/views/UsersLogView.vue'
import SettingsView from '@/views/SettingsView.vue'
import AboutView from '@/views/AboutView.vue'
import TasksView from '@/views/TasksView.vue'

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'Home',
			component: HomeView,
			meta: {
				scope: 'private',
			},
		},
		{
			path: '/acceso',
			name: 'Login',
			component: LoginView,
			meta: {
				scope: 'public',
			},
		},
		{
			path: '/salir',
			name: 'Logout',
			component: LogoutView,
			meta: {
				scope: 'any',
			},
		},
		{
			path: '/tareas',
			name: 'Tasks',
			component: TasksView,
			meta: {
				scope: 'private',
			},
		},
		{
			path: '/sistema/usuarios',
			name: 'Users',
			component: UsersView,
			meta: {
				scope: 'private',
			},
		},
		{
			path: '/sistema/registros',
			name: 'UsersLog',
			component: UsersLogView,
			meta: {
				scope: 'private',
			},
		},
		{
			path: '/sistema/configuracion',
			name: 'Settings',
			component: SettingsView,
			meta: {
				scope: 'private',
			},
		},
		{
			path: '/sistema/acerca',
			name: 'About',
			component: AboutView,
			meta: {
				scope: 'private',
			},
		},
	]
})

export default router
