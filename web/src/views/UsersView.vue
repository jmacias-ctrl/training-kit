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
import AddUserModal from '@/components/AddUserModal.vue'
import BlockUserModal from '@/components/BlockUserModal.vue'
import ChangeUserPasswordModal from '@/components/ChangeUserPasswordModal.vue'
import DeleteUserModal from '@/components/DeleteUserModal.vue'
import UnblockUserModal from '@/components/UnblockUserModal.vue'
import ChangeUserRoleModal from '@/components/ChangeUserRoleModal.vue'
import { computed } from 'vue'
import { useStore } from 'vuex'
export default {
	name: 'UsersView',
	data: () => ({
		user: {
			id: null,
			name: null,
			email: null,
			blocked: null,
			blocked_at: null,
			enabled: null,
			disabled_at: null,
			created_at: null,
			updated_at: null,
		},
		loaders: {
			name: {
				active: false,
				id: null,
				value: null,
				loading: false,
			},
			email: {
				active: false,
				id: null,
				value: null,
				loading: false,
			},
		},
		modal: null
	}),
	components: {
		AddUserModal,
		DeleteUserModal,
		ChangeUserPasswordModal,
		BlockUserModal,
		UnblockUserModal,
		ChangeUserRoleModal,
	},
	setup () {
		const store = useStore()
		return {
			system: computed(() => store.getters.system),
			session: computed(() => store.getters.session),
			users: computed(() => store.getters.users),
			modals: computed(() => store.getters.modals),
			ui_theme: computed(() => store.getters.system.settings.ui.theme),
			browse_users: () => store.dispatch('users'),
			user_roles: user_id => store.dispatch('user_roles', user_id),
		}
	},
	created() {
		this.browse_users();
	},
	mounted() {
	},
	unmounted() {
	},
	computed: {
		val_email() {
			var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@(([[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
			return this.loaders.email.value == null ? null : this.loaders.email.value.length > 0 && regex.test(this.loaders.email.value) ? true : false;
		},
		val_name() {
			return this.loaders.name.value == null ? null : this.loaders.name.value.length > 0 ? true : false;
		},
	},
	methods: {
		openAddUserModal() {
            this.modals.AddUserModal.show();
		},
		openDeleteUserModal(user) {
			this.user = user;
            this.modals.DeleteUserModal.show();
		},
		openChangeUserPasswordModal(user) {
			this.user = user;
            this.modals.ChangeUserPasswordModal.show();
		},
		openBlockUserModal(user) {
			this.user = user;
            this.modals.BlockUserModal.show();
		},
		openUnblockUserModal(user) {
			this.user = user;
            this.modals.UnblockUserModal.show();
		},
		openChangeUserRoleModal(user) {
			this.user = user;
			this.user_roles(user.id)
            this.modals.ChangeUserRoleModal.show();
		},
		enableNameForm(item) {
			this.loaders.name.active = true;
			this.loaders.name.id = item.id;
			this.loaders.name.value = item.name;
		},
		disableNameForm() {
			this.loaders.name.active = false;
			this.loaders.name.id = null;
			this.loaders.name.value = null;
		},
		changeName() {
			this.loaders.name.loading = true;
			this.$store.dispatch('change_user_name', {
				user_id: this.loaders.name.id,
				name: this.loaders.name.value,
			})
			.then(() => {
				this.loaders.name.loading = false;
				this.browse_users();
				this.disableNameForm();
			});
		},
		enableEmailForm(item) {
			this.loaders.email.active = true;
			this.loaders.email.id = item.id;
			this.loaders.email.value = item.email;
		},
		disableEmailForm() {
			this.loaders.email.active = false;
			this.loaders.email.id = null;
			this.loaders.email.value = null;
		},
		changeEmail() {
			this.loaders.email.loading = true;
			this.$store.dispatch('change_user_email', {
				user_id: this.loaders.email.id,
				email: this.loaders.email.value,
			})
			.then(() => {
				this.loaders.email.loading = false;
				this.browse_users();
				this.disableEmailForm();
			});
		},
	}
}
</script>

<template>
	<AddUserModal />
	<DeleteUserModal :user="user" />
	<ChangeUserPasswordModal :user="user" />
	<BlockUserModal :user="user" />
	<UnblockUserModal :user="user" />
	<ChangeUserRoleModal :user="user"  />
	<div class="container mt-5">
		<div class="row">
			<div class="col-sm-4">
				<div class="card mb-4" :class="{ 'text-bg-dark' : ui_theme === 'dark' }">
					<div class="card-header">
						<p class="mb-0 fs-11 fw-6">Sistema</p>
					</div>
					<div class="card-body">
						<button class="btn btn-primary w-100 text-start mb-2" @click="this.$router.push({ name: 'Users' })">
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
								<p class="mb-0 fs-14 fw-6">Usuarios</p>
								<p class="mb-0">Gestione cuentas y roles de usuarios.</p>
							</div>
							<div class="col col-auto text-end">
								<button class="btn btn-primary mt-2" @click="openAddUserModal()">
									<i class="far fa-plus me-2"></i>
									<span>Agregar Usuario</span>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div v-if="users.loading">
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
				<div v-else class="list-group">
					<div v-for="(item, index) in users.items" :key="index" class="list-group-item py-2 ps-4 pe-3" :class="{ 'text-bg-dark border-dark' : ui_theme === 'dark' }">
						<div class="row">
							<div class="col col-auto">
								<span v-if="item.blocked && item.blocked === true">
									<i class="fas fa-fw mt-3 text-dark fa-lock"></i>
								</span>
								<span v-else>
									<i class="far fa-fw mt-3 text-secondary fa-user"></i>
								</span>
							</div>
							<div class="col">
								<div v-if="loaders.name.active === true && loaders.name.id === item.id">
									<div class="row">
										<div class="col-auto">
											<div class="input-group">
												<input v-model="loaders.name.value" :disabled="loaders.name.loading" type="text" class="form-control form-control-sm">
												<button class="btn btn-outline-secondary btn-sm" @click="disableNameForm()" :disabled="loaders.name.loading">
													<i class="fas fa-fw fa-times"></i>
												</button>
												<button class="btn btn-primary btn-sm" :disabled="loaders.name.value == item.name || loaders.name.loading || !val_name" @click="changeName()">
													<i class="fas fa-fw fa-check"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<div v-else>
									<p class="mb-0 fw-6">
										<span v-if="item.blocked && item.blocked === true" class="text-muted">
											<del>{{ item.name }}</del>
											(Bloqueado)
										</span>
										<span v-else>{{ item.name }}</span>
										<button class="btn btn-light btn-sm py-0 px-1 fs-09 ms-1 text-secondary" @click="enableNameForm(item)" :class="{ 'btn-dark text-white' : ui_theme === 'dark' }">
											<i class="fas fa-pen-to-square"></i>
										</button>
									</p>
								</div>
								<div v-if="loaders.email.active === true && loaders.email.id === item.id">
									<div class="row">
										<div class="col-auto">
											<div class="input-group">
												<input v-model="loaders.email.value" :disabled="loaders.email.loading" type="text" class="form-control form-control-sm">
												<button class="btn btn-outline-secondary btn-sm" @click="disableEmailForm()" :disabled="loaders.email.loading">
													<i class="fas fa-fw fa-times"></i>
												</button>
												<button class="btn btn-primary btn-sm" :disabled="loaders.email.value == item.email || loaders.email.loading || !val_email" @click="changeEmail()">
													<i class="fas fa-fw fa-check"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<div v-else>
									<p class="mb-0 fs-09">
										<del v-if="item.blocked && item.blocked === true">{{ item.email }}</del><span v-else>{{ item.email }}</span>
										<button class="btn btn-light btn-sm py-0 px-1 fs-08 ms-1 text-secondary" @click="enableEmailForm(item)" :class="{ 'btn-dark text-white' : ui_theme === 'dark' }">
											<i class="fas fa-pen-to-square"></i>
										</button>
									</p>
								</div>
							</div>
							<div class="col col-auto text-end">
								<div class="dropdown">
									<button class="btn btn-outline-primary btn-sm mt-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" :class="{ 'btn-outline-light' : ui_theme === 'dark' }">
										Opciones
									</button>
									<ul class="dropdown-menu dropdown-menu-end">
										<li>
											<a class="dropdown-item" href="#" @click="openChangeUserRoleModal(item)">
												<i class="fas fa-fw fa-user-shield me-2"></i>
												<span>Roles</span>
											</a>
										</li>
										<li v-if="item && item.blocked && item.blocked === true">
											<a class="dropdown-item" href="#" @click="openUnblockUserModal(item)">
												<i class="fas fa-fw fa-unlock me-2"></i>
												<span>Desbloquear</span>
											</a>
										</li>
										<li v-else>
											<a class="dropdown-item" href="#" @click="openBlockUserModal(item)">
												<i class="fas fa-fw fa-lock me-2"></i>
												<span>Bloquear</span>
											</a>
										</li>
										<li>
											<a class="dropdown-item" href="#" @click="openChangeUserPasswordModal(item)">
												<i class="far fa-fw fa-asterisk me-2"></i>
												<span>Contraseña</span>
											</a>
										</li>
										<li>
											<a class="dropdown-item" href="#" @click="openDeleteUserModal(item)">
												<i class="far fa-fw fa-trash-can me-2"></i>
												<span>Eliminar</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
