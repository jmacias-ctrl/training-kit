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
	name: 'AboutView',
	data: () => ({
		modal: null
	}),
	components: {
	},
	setup () {
		const store = useStore()
		return {
			system: computed(() => store.getters.system),
			session: computed(() => store.getters.session),
			modals: computed(() => store.getters.modals),
			ui_theme: computed(() => store.getters.system.settings.ui.theme),
		}
	},
	created() {
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
						<button class="btn btn-light w-100 text-start mb-2" @click="this.$router.push({ name: 'UsersLog' })" :class="{ 'btn-dark' : ui_theme === 'dark' }">
							<i class="fas fa-fw fa-database me-2"></i>
							<span>Registros</span>
						</button>
						<button class="btn btn-light w-100 text-start mb-2" @click="this.$router.push({ name: 'Settings' })" :class="{ 'btn-dark' : ui_theme === 'dark' }">
							<i class="fas fa-fw fa-gear me-2"></i>
							<span>Configuración</span>
						</button>
						<button class="btn btn-primary w-100 text-start" @click="this.$router.push({ name: 'About' })">
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
								<p class="mb-2 fs-14 fw-6">Acerca de</p>
							</div>
							<div class="col col-auto text-end">
							</div>
						</div>
						<div class="list-group">
							<div class="list-group-item list-group-item-primary" :class="{ 'text-bg-dark border-secondary' : ui_theme === 'dark' }">
								<div class="row">
									<div class="col-3 py-1">
										Sistema
									</div>
									<div class="col-9 py-1 fw-bold">
										Eniwer&reg; Training Kit
									</div>
									<div class="col-3 py-1">
										Desarrollado por
									</div>
									<div class="col-9 py-1 fw-bold">
										ENIWER&reg; SpA
									</div>
									<div class="col-3 py-1">
										Versión
									</div>
									<div class="col-9 py-1 fw-bold">
										1.0
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
