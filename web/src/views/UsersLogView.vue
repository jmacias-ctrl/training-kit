<!--
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
-->
<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
export default {
	name: 'UsersLogView',
	data: () => ({
	}),
	components: {
	},
	setup () {
		const store = useStore()
		return {
			system: computed(() => store.getters.system),
			session: computed(() => store.getters.session),
			user_logs: computed(() => store.getters.user_logs),
			ui_theme: computed(() => store.getters.system.settings.ui.theme),
			browse_user_logs: () => store.dispatch('user_logs'),
		}
	},
	created() {
		this.browse_user_logs();
	},
	mounted() {
	},
	unmounted() {
	},
	computed: {
	},
	methods: {
	}
}
</script>

<template>
	<div class="container mt-5">
		<div class="row">
			<div class="col-sm-4">
				<div class="card mb-4" :class="{ 'text-bg-dark' : ui_theme === 'dark' }">
					<div class="card-header">
						<p class="mb-0 fs-11 fw-6">Sistema</p>
					</div>
					<div class="card-body">
						<button class="btn btn-light w-100 text-start mb-2" @click="this.$router.push({ name: 'Users' })" :class="{ 'btn-dark' : ui_theme === 'dark' }">
							<i class="fas fa-fw fa-user me-2"></i>
							<span>Usuarios</span>
						</button>
						<button class="btn btn-primary w-100 text-start mb-2" @click="this.$router.push({ name: 'UsersLog' })">
							<i class="fas fa-fw fa-database me-2"></i>
							<span>Registros</span>
						</button>
						<button class="btn btn-light w-100 text-start mb-2" @click="this.$router.push({ name: 'Settings' })" :class="{ 'btn-dark' : ui_theme === 'dark' }">
							<i class="fas fa-fw fa-gear me-2"></i>
							<span>Configuración</span>
						</button>
						<button class="btn btn-light w-100 text-start" @click="this.$router.push({ name: 'About' })" :class="{ 'btn-dark' : ui_theme === 'dark' }">
							<i class="fas fa-fw fa-info-circle me-2"></i>
							<span>Acerca de</span>
						</button>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="card mb-3" :class="{ 'text-bg-dark' : ui_theme === 'dark' }">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<p class="mb-0 fs-14 fw-6">Registros</p>
								<p class="mb-0">Examine la actividad de los usuarios en el sistema.</p>
							</div>
							<div class="col col-auto text-end">
								<button class="btn btn-primary mt-2" @click="browse_user_logs()" :disabled="user_logs.loading">
									<i class="fas fa-rotate-right me-2"></i>
									<span>Refrescar Información</span>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="card" :class="{ 'text-bg-dark' : ui_theme === 'dark' }">
					<div class="card-body table-responsive">
						<div class="row mb-0">
							<div class="col">
								<ul class="pagination">
									<li class="page-item" :class="{ 'disabled' : user_logs.items.current_page == 1 }">
										<a class="page-link" href="#" @click="user_logs.browser.page = 1; browse_user_logs();">
											<i class="fas fa-angles-left"></i>
										</a>
									</li>
									<li class="page-item" :class="{ 'disabled' : user_logs.items.current_page == 1 }">
										<a class="page-link" href="#" @click="user_logs.browser.page = user_logs.items.current_page - 1; browse_user_logs();">
											<i class="fas fa-angle-left"></i>
										</a>
									</li>
									<li class="page-item" v-for="(item, index) in user_logs.items.last_page" :key="index" :class="{ 'active' : user_logs.items.current_page == item }">
										<a class="page-link" href="#" @click="user_logs.browser.page = item; browse_user_logs();">{{ item }}</a>
									</li>
									<li class="page-item" :class="{ 'disabled' : user_logs.items.current_page == user_logs.items.last_page }">
										<a class="page-link" href="#" @click="user_logs.browser.page = user_logs.items.current_page + 1; browse_user_logs();">
											<i class="fas fa-angle-right"></i>
										</a>
									</li>
									<li class="page-item" :class="{ 'disabled' : user_logs.items.current_page == user_logs.items.last_page }">
										<a class="page-link" href="#" @click="user_logs.browser.page = user_logs.items.last_page; browse_user_logs();">
											<i class="fas fa-angles-right"></i>
										</a>
									</li>
								</ul>
							</div>
							<div class="col-auto text-end">
								<select v-model="user_logs.browser.limit" class="form-select" @change="browse_user_logs()">
									<option :value="10">10 por página</option>
									<option :value="25">25 por página</option>
									<option :value="50">50 por página</option>
									<option :value="100">100 por página</option>
								</select>
							</div>
						</div>
						<div v-if="user_logs.loading">
							<div class="list-group">
								<div class="list-group-item placeholder-glow" :class="{ 'text-bg-dark border-secondary' : ui_theme === 'dark' }">
									<div class="placeholder w-100"></div>
								</div>
								<div class="list-group-item placeholder-glow" :class="{ 'text-bg-dark border-secondary' : ui_theme === 'dark' }">
									<div class="placeholder w-100"></div>
								</div>
								<div class="list-group-item placeholder-glow" :class="{ 'text-bg-dark border-secondary' : ui_theme === 'dark' }">
									<div class="placeholder w-100"></div>
								</div>
								<div class="list-group-item placeholder-glow" :class="{ 'text-bg-dark border-secondary' : ui_theme === 'dark' }">
									<div class="placeholder w-100"></div>
								</div>
								<div class="list-group-item placeholder-glow" :class="{ 'text-bg-dark border-secondary' : ui_theme === 'dark' }">
									<div class="placeholder w-100"></div>
								</div>
							</div>
						</div>
						<div v-else>
							<table class="table table-hover table-bordered table-sm mb-0" :class="{ 'table-dark' : ui_theme === 'dark' }">
								<thead>
									<tr>
									<th scope="col">N°</th>
									<th scope="col">Fecha/Hora</th>
									<th scope="col">Método</th>
									<th scope="col">Usuario</th>
									<th scope="col">Endpoint</th>
									<th scope="col">Cuerpo</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in user_logs.items.data" :key="index">
										<th scope="row">{{ item.id }}</th>
										<td class="text-truncate">{{ item.created_at }}</td>
										<td>{{ item.method }}</td>
										<td>{{ item.user.email }}</td>
										<td>{{ item.path }}</td>
										<td>{{ item.body }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>