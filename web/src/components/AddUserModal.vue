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
	name: 'AddUserModal',
	data() {
		return {
			loading: false,
			user: {
				name: null,
				email: null,
				password_auto: true,
				password: null,
			}
		}
	},
	setup () {
		const store = useStore()
		return {
			users: () => store.dispatch('users'),
			add_user: (data) => store.dispatch('add_user', data),
			modals: computed(() => store.getters.modals),
		}
	},
	created() {
	},
	mounted() {
        this.$store.commit('AddUserModal', new Modal(this.$refs.AddUserModal));
	},
	unmounted() {
		this.$store.commit('AddUserModal', null);
	},
	computed: {
		val_name() {
			return this.user.name == null ? null : this.user.name.length > 0 ? true : false;
		},
		val_email() {
			var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@(([[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
			return this.user.email == null ? null : this.user.email.length > 0 && regex.test(this.user.email) ? true : false;
		},
		val_password() {
			return this.user.password_auto === true || (this.user.password_auto === false && this.user.password != null && this.user.password.length > 0) ? true : false;
		},
		val_full() {
			return this.val_name && this.val_email && this.val_password ? true : false;
		},
	},
	methods: {
		reset() {
			this.user.name = null;
			this.user.email = null;
			this.user.password_auto = true;
			this.user.password = null;
		},
		addUser() {
			this.loading = true;
			this.add_user(this.user).then(() => {
				this.loading = false;
				this.reset();
				this.users();
				this.close();
			});
		},
		close() {
			this.modals.AddUserModal.hide();
		},
	}
}
</script>

<template>
	<div class="modal fade modal-md" ref="AddUserModal" tabindex="-1" aria-labelledby="addUser" aria-hidden="true" @close="reset(); close();">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="addUser">Agregar Usuario</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body" :class="{ 'opacity-50': loading === true }">
					<div class="row">
						<div class="col">
							<div class="form-floating mb-3">
								<input
									v-model="user.name" 
									:class="{
										'is-valid' : val_name === true,
										'is-invalid' : val_name === false
									}"
									type="text"
									class="form-control"
									id="name"
								>
								<label for="name">Nombre</label>
								<div class="invalid-feedback">
									Ingrese un nombre.
								</div>
							</div>
						</div>
						<div class="col">
							<div class="form-floating mb-3">
								<input
									v-model="user.email" 
									:class="{
										'is-valid' : val_email === true,
										'is-invalid' : val_email === false
									}"
									type="text"
									class="form-control"
									id="email"
								>
								<label for="email">Correo electrónico</label>
								<div class="invalid-feedback">
									Ingrese una dirección válida.
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group mb-3">
								<label class="form-label fw-6">Contraseña</label>
								<div class="form-check">
									<input
										class="form-check-input"
										type="radio"
										id="passwordAuto"
										v-model="user.password_auto"
										:value="true"
										:class="{
											'is-valid' : val_password === true,
											'is-invalid' : val_password === false
										}"
									>
									<label class="form-check-label" for="passwordAuto">
										Generar automáticamente
									</label>
								</div>
								<div class="form-check">
									<input
										class="form-check-input"
										type="radio"
										id="passwordManual"
										v-model="user.password_auto"
										:value="false"
										:class="{
											'is-valid' : val_password === true,
											'is-invalid' : val_password === false
										}"
									>
									<label class="form-check-label" for="passwordManual">
										Configurar manualmente
									</label>
								</div>
							</div>
							<div class="form-floating" v-if="user.password_auto === false">
								<input
									v-model="user.password"
									type="text"
									class="form-control"
									id="password"
									placeholder="Contraseña"
									:class="{
										'is-valid' : val_password === true,
										'is-invalid' : val_password === false
									}"
								>
								<label for="password">Contraseña</label>
									<div class="invalid-feedback">
										Ingrese una contraseña.
									</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" :disabled="loading" @click="close()">Cancelar</button>
					<button class="btn" :class="{ 'btn-primary' : val_full, 'btn-secondary' : !val_full }" @click="addUser()" :disabled="!val_full||loading">Confirmar</button>
				</div>
			</div>
		</div>
	</div>
</template>
