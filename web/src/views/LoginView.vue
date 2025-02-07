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
	name: 'LoginView',
	data() {
		return {
			loading: false,
			error: {
				active: false,
				code: null,
				message: null,
			}
		}
	},
	setup () {
		const store = useStore()
		return {
			system: computed(() => store.getters.system),
			session: computed(() => store.getters.session),
			ui_theme: computed(() => store.getters.system.settings.ui.theme),
			refresh: () => store.dispatch('refresh'),
			login: () => store.dispatch('login'),
		}
	},
	created() {
	},
	mounted() {
	},
	unmounted() {
	},
	computed: {
		val_username() {
			var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@(([[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
			return this.session.credentials.username == null ? null : this.session.credentials.username.length > 0 && regex.test(this.session.credentials.username) ? true : false;
		},
		val_password() {
			return this.session.credentials.password == null ? null : this.session.credentials.password.length > 0 ? true : false;
		},
		val_full() {
			return this.val_username && this.val_password ? true : false;
		},
		websocket: {
			get() { return this.$store.getters.websocket; },
			set(data) { this.$store.commit('websocket', data); }
		},
		websocketURL() { return import.meta.env.VITE_APP_WEBSOCKET },
	},
	methods: {
		submitForm() {
			this.loading = true;
			this.error.active = false;
			this.login({
				username: this.session.credentials.username,
				password: this.session.credentials.password
			})
			.then(() => {
				this.$store.dispatch('user').then(() => {
					this.websocket.socket.auth = { token: this.websocket.token };
					if(!this.websocket.socket.connected) this.websocket.socket.connect();
					this.websocket.socket.on('connect', () => this.websocket.online = true);
					this.websocket.socket.on('disconnect', () => this.websocket.online = false);
				});
				this.$router.push({ name: 'Home' });
				this.loading = false;
			})
			.catch(error => {
				console.log(error)
				this.error.active = true;
				this.loading = false;
			})
		}
	}
}
</script>

<template>
	<div class="container pt-5" :class="{ 'opacity-50' : loading }">
		<div class="row justify-content-center">
			<div class="col-auto">
				<div class="card" :class="{ 'text-bg-dark' : ui_theme === 'dark' }">
					<div class="card-body px-5 pt-5 pb-4">
						<div v-if="ui_theme === 'light'">
							<img src="@/assets/imagotipo.svg" class="mb-4" style="height: 24px; width: auto;" />
						</div>
						<div v-else>
							<img src="@/assets/imagotipo-dark.svg" class="mb-4" style="height: 24px; width: auto;" />
						</div>
						<p class="mb-3 fs-16 fw-6">Training Kit</p>
						<div class="alert alert-danger px-3 py-2 fs-09" v-if="error.active">
							<span>Ha ocurrido un error al procesar su solicitud.<br>Por favor, inténtelo nuevamente.</span>
						</div>
						<div class="mb-2">
							<label for="username" class="form-label">E-mail</label>
							<input
								id="username"
								:class="{
									'is-valid' : val_username === true,
									'is-invalid' : val_username === false,
								}"
								v-model="session.credentials.username"
								class="form-control"
							>
						</div>
						<div class="mb-4">
							<label for="password" class="form-label">Contraseña</label>
							<input
								id="password"
								:class="{
									'is-valid' : val_password === true,
									'is-invalid' : val_password === false,
								}"
								v-model="session.credentials.password"
								type="password"
								class="form-control"
							>
						</div>
						<button @click="submitForm()" class="btn btn-primary w-100 mb-3" :disabled="loading || !val_full">Acceder</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>