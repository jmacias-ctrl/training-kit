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
	name: 'DeleteUserModal',
	data() {
		return {
			loading: false,
		}
	},
	setup () {
		const store = useStore()
		return {
			users: () => store.dispatch('users'),
			delete_user: (user_id) => store.dispatch('delete_user', user_id),
			modals: computed(() => store.getters.modals),
		}
	},
	created() {
	},
	mounted() {
        this.$store.commit('DeleteUserModal', new Modal(this.$refs.DeleteUserModal));
	},
	props: {
		user: Object,
	},
	unmounted() {
		this.$store.commit('DeleteUserModal', null);
	},
	computed: {
	},
	methods: {
		deleteUser() {
			this.loading = true;
			this.delete_user(this.user.id).then(() => {
				this.loading = false;
				this.users();
				this.close();
			});
		},
		close() {
			this.modals.DeleteUserModal.hide();
		},
	}
}
</script>

<template>
	<div class="modal fade modal-md" ref="DeleteUserModal" tabindex="-1" aria-labelledby="deleteUser" aria-hidden="true" @close="close();">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="deleteUser">Eliminar Usuario</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body" :class="{ 'opacity-50': loading === true }">
					<div class="row">
						<div class="col">
							<p class="mb-0 fs-12">¿Desea eliminar a <strong>{{ user && user.name ? user.name : '' }}</strong>?</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Cancelar" :disabled="loading">Cancelar</button>
					<button class="btn btn-primary" @click="deleteUser()" :disabled="loading">Confirmar</button>
				</div>
			</div>
		</div>
	</div>
</template>
