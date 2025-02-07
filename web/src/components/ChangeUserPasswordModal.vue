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
import { useStore } from 'vuex'
import { computed } from 'vue'
import { Modal } from 'bootstrap'
export default {
	name: 'ChangeUserPasswordModal',
	data() {
		return {
			loading: false,
			auto: true,
			password: null,
			repeat_password: null,
		}
	},
	setup () {
		const store = useStore()
		return {
			users: () => store.dispatch('users'),
			change_user_password: (data) => store.dispatch('change_user_password', data),
			modals: computed(() => store.getters.modals),
		}
	},
	created() {
	},
	mounted() {
        this.$store.commit('ChangeUserPasswordModal', new Modal(this.$refs.ChangeUserPasswordModal));
	},
	props: {
		user: Object,
	},
	unmounted() {
		this.$store.commit('ChangeUserPasswordModal', null);
	},
	computed: {
		val_type() {
			return this.auto != null ? true : false;
		},
		val_password() {
			return this.password != null && this.password.length > 0 ? true : false;
		},
		val_repeat() {
			return this.val_password && this.repeat_password != null && this.repeat_password.length > 0 && this.password == this.repeat_password ? true : false;
		},
	},
	methods: {
		changeUserPassword() {
			this.loading = true;
			this.change_user_password({
				user_id: this.user.id,
				password: this.password,
			}).then(() => {
				this.loading = false;
				this.users();
				this.close();
			});
		},
		close() {
			this.modals.ChangeUserPasswordModal.hide();
		},
	}
}
</script>

<template>
	<div class="modal fade modal-md" ref="ChangeUserPasswordModal" tabindex="-1" aria-labelledby="changeUserPassword" aria-hidden="true" @close="close();">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="changeUserPassword">Contraseña de Usuario</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body" :class="{ 'opacity-50': loading === true }">
					<div class="row">
						<div class="col-12">
							<p class="mb-3 fs-12">Asignar nueva contraseña a <strong>{{ user && user.name ? user.name : '' }}</strong>:</p>
						</div>
						<div class="col">
							<div class="form-group mb-3 fs-11">
								<div class="form-check">
									<input
										class="form-check-input"
										type="radio"
										id="changePasswordAuto"
										v-model="auto"
										:value="true"
										:class="{
											'is-valid' : val_type === true,
											'is-invalid' : val_type === false
										}"
									>
									<label class="form-check-label" for="changePasswordAuto">
										Generar automáticamente
									</label>
								</div>
								<div class="form-check">
									<input
										class="form-check-input"
										type="radio"
										id="changePasswordManual"
										v-model="auto"
										:value="false"
										:class="{
											'is-valid' : val_type === true,
											'is-invalid' : val_type === false
										}"
									>
									<label class="form-check-label" for="changePasswordManual">
										Configurar manualmente
									</label>
								</div>
							</div>
							<div class="form-floating mb-3" v-if="auto === false">
								<input
									v-model="password"
									type="password"
									class="form-control"
									id="password"
									:class="{
										'is-valid' : val_password === true,
										'is-invalid' : val_password === false
									}"
								>
								<label for="password">Nueva Contraseña</label>
							</div>
							<div class="form-floating" v-if="auto === false">
								<input
									v-model="repeat_password"
									type="password"
									class="form-control"
									id="repeat_password"
									:class="{
										'is-valid' : val_repeat === true,
										'is-invalid' : val_repeat === false
									}"
								>
								<label for="repeat_password">Repita Contraseña</label>
								<div class="invalid-feedback">
									{{ !val_password && !val_repeat ? 'Escriba una nueva contraseña.' : 'Las contraseñas deben coincidir.' }}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Cancelar" :disabled="loading">Cancelar</button>
					<button class="btn btn-primary" @click="changeUserPassword()" :disabled="(!auto && !val_repeat) ||loading">Confirmar</button>
				</div>
			</div>
		</div>
	</div>
</template>
