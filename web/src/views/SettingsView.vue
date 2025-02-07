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
	name: 'SettingsView',
	data: () => ({
		loader: {
			active: false,
			id: null,
			value: null,
			loading: false,
		},
	}),
	components: {
	},
	setup () {
		const store = useStore()
		return {
			system: computed(() => store.getters.system),
			session: computed(() => store.getters.session),
			settings: computed(() => store.getters.settings),
			ui_theme: computed(() => store.getters.system.settings.ui.theme),
			browse_settings: () => store.dispatch('settings'),
		}
	},
	created() {
		this.browse_settings();
	},
	mounted() {
	},
	unmounted() {
	},
	computed: {
	},
	methods: {
		enableEdit(item) {
			this.loader.id = item.id;
			this.loader.value = item.value.data;
			this.loader.active = true;
		},
		disableEdit() {
			this.loader.id = null;
			this.loader.value = null;
			this.loader.active = false;
		},
		saveEdit(item) {
			this.loader.loading = true;
			this.$store.dispatch('update_setting', {
				setting_id: this.loader.id,
				value: this.loader.value,
				type: item.value.type,
			})
			.then(() => {
				this.loader.loading = false;
				this.disableEdit();
				this.browse_settings();
			});
		}
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
						<button class="btn btn-light w-100 text-start mb-2" @click="this.$router.push({ name: 'UsersLog' })" :class="{ 'btn-dark' : ui_theme === 'dark' }">
							<i class="fas fa-fw fa-database me-2"></i>
							<span>Registros</span>
						</button>
						<button class="btn btn-primary w-100 text-start mb-2" @click="this.$router.push({ name: 'Settings' })">
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
								<p class="mb-0 fs-14 fw-6">Configuración</p>
								<p class="mb-0">Examine la actividad de los usuarios en el sistema.</p>
							</div>
							<div class="col col-auto text-end">
								<button class="btn btn-primary mt-2" @click="browse_settings()" :disabled="settings.loading">
									<i class="fas fa-rotate-right me-2"></i>
									<span>Refrescar Información</span>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div v-if="settings.loading">
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
				<div class="card mb-5" v-else :class="{ 'text-bg-dark' : ui_theme === 'dark' }">
					<div class="card-body" :class="{ 'opacity-50' : settings.loading }">
						<div class="list-group">
							<div class="list-group-item pb-3" v-for="(item, index) in settings.items" :key="index" :class="{ 'opacity-50' : loader.loading && loader.id == item.id, 'text-bg-dark border-dark' : ui_theme === 'dark' }">
								<div class="row">
									<div class="col">
										<code>{{ item.name }}</code>
										<p class="mb-2 fs-09">{{ item.description }}</p>
									</div>
									<div class="col-auto pt-2 text-end text-secondary">
										<i class="fas fa-fw fa-lock me-2" v-if="item.locked == true"></i>
										<i class="fas fa-fw fa-lock-open me-2" v-else></i>
									</div>
								</div>
								<div class="card" :class="{ 'text-bg-dark' : ui_theme === 'dark' }">
									<div class="card-body pt-2 pb-2 px-3">
										<div class="row">
											<div class="col">
												<pre class="mb-0">{{ item.value }}</pre>
											</div>
											<div class="col text-end" v-if="item.locked == false">
												<div class="input-group" v-if="loader.active && loader.id == item.id">
													<input v-model="loader.value" type="text" class="form-control">
													<button class="btn btn-outline-secondary" @click="disableEdit()" :disabled="loader.loading">
														<i class="fas fa-fw fa-times"></i>
													</button>
													<button class="btn btn-primary" :disabled="(loader.value == item.value.data) || loader.loading" @click="saveEdit(item)">
														<i class="fas fa-check"></i>
													</button>
												</div>
												<div v-else>
													<button class="btn btn-primary" @click="enableEdit(item)">
														<i class="fas fa-pen-to-square"></i>
													</button>
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer fs-09 text-secondary py-1">
										<div class="row">
											<div class="col">
												Revisión {{ item.revision }}
											</div>
											<div class="col text-end">
												{{ item.updated }}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>