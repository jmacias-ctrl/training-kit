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
	name: 'ChangeUserRoleModal',
	data() {
		return {
			modal: null,
		}
	},
	setup () {
		const store = useStore();
		return {
			user_roles: computed(() => store.getters.modals.user_roles),
			users: () => store.dispatch('users'),
			modals: computed(() => store.getters.modals),
		}
	},
	created() {
	},
	mounted() {
        this.$store.commit('ChangeUserRoleModal', new Modal(this.$refs.ChangeUserRoleModal));
	},
	props: {
		user: Object,
	},
	unmounted() {
		this.$store.commit('ChangeUserRoleModal', null);
	},
	computed: {
		val_full() {
			return this.user_roles.items.user == true || this.user_roles.items.super == true || this.user_roles.items.admin == true ? true : false;
		},
	},
	methods: {
		reset() {
			this.$store.commit('clear_user_roles')
		},
		close() {
			this.modals.ChangeUserRoleModal.hide();
		},
		changeUserRole(user_id) {
			this.$store.dispatch('change_user_roles', user_id)
			.then(() => {
				this.users();
				this.close();
			});
		},
	}
}
</script>

<template>
	<div class="modal fade modal-md" ref="ChangeUserRoleModal" tabindex="-1" aria-labelledby="changeUserRoles" aria-hidden="true" @close="close();">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="changeUserRoles">Roles de Usuario</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body" :class="{ 'opacity-50': user_roles.loading === true }">
					<p class="mb-3 fs-12">Roles asignados a <strong>{{ user && user.name ? user.name : '' }}</strong>:</p>
					<div class="card mb-3" :class="{ 'border-success' : user_roles.items.user == true }">
						<div class="card-body" @click="user_roles.items.user = !user_roles.items.user">
							<div class="form-check">
								<input
									class="form-check-input"
									type="checkbox"
									id="roleUser"
									v-model="user_roles.items.user"
									:class="{ 'is-valid' : user_roles.items.user == true }"
								>
								<label class="form-check-label ps-1" for="roleUser" @click="user_roles.items.user = !user_roles.items.user">
									<p class="mb-0 fw-6" :class="{ 'text-success' : user_roles.items.user == true }">
										<span>Operación</span>
										<i class="fas fa-user ms-2"></i>
									</p>
									<p class="mb-0" :class="{ 'text-success' : user_roles.items.user == true, 'text-muted' : user_roles.items.user == false }">
										<span>Puede registrar nueva información en el sistema y mantenerla actualizada.</span>
									</p>
								</label>
							</div>
						</div>
					</div>
					<div class="card mb-3" :class="{ 'border-success' : user_roles.items.super == true }">
						<div class="card-body" @click="user_roles.items.super = !user_roles.items.super">
							<div class="form-check">
								<input
									class="form-check-input"
									type="checkbox"
									id="roleSuper"
									v-model="user_roles.items.super"
									:class="{ 'is-valid' : user_roles.items.super == true }"
								>
								<label class="form-check-label ps-1" for="roleSuper" @click="user_roles.items.super = !user_roles.items.super">
									<p class="mb-0 fw-6" :class="{ 'text-success' : user_roles.items.super == true }">
										<span>Supervisión</span>
										<i class="fas fa-user-check ms-2"></i>
									</p>
									<p class="mb-0 fs-10" :class="{ 'text-success' : user_roles.items.super == true, 'text-muted' : user_roles.items.super == false }">
										<span>Puede ver la información registrada por todos los usuarios.</span>
									</p>
								</label>
							</div>
						</div>
					</div>
					<div class="card mb-3" :class="{ 'border-success' : user_roles.items.admin == true }">
						<div class="card-body" @click="user_roles.items.admin = !user_roles.items.admin">
							<div class="form-check">
								<input
									class="form-check-input"
									type="checkbox"
									id="roleAdmin"
									v-model="user_roles.items.admin"
									:class="{
										'is-valid' : user_roles.items.admin == true,
									}"
								>
								<label class="form-check-label ps-1" for="roleAdmin" @click="user_roles.items.admin = !user_roles.items.admin">
									<p class="mb-0 fw-6" :class="{ 'text-success' : user_roles.items.admin == true }">
										<span>Administración</span>
										<i class="fas fa-user-gear ms-2"></i>
									</p>
									<p class="mb-0 fs-10" :class="{ 'text-success' : user_roles.items.admin == true, 'text-muted' : user_roles.items.admin == false }">
										<span>Puede administrar usuarios y configurar el sistema.</span>
									</p>
								</label>
							</div>
						</div>
					</div>
					<div class="alert alert-danger mb-0" v-if="!user_roles.loading && !val_full">
						<p class="mb-0">Se requiere un rol como mínimo.</p>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Cancelar" :disabled="user_roles.loading">Cancelar</button>
					<button class="btn btn-primary" @click="changeUserRole(user.id)" :disabled="user_roles.loading||!val_full">Confirmar</button>
				</div>
			</div>
		</div>
	</div>
</template>
