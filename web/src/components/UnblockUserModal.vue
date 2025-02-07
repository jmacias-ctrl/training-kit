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
	name: 'UnblockUserModal',
	data() {
		return {
			loading: false,
		}
	},
	setup () {
		const store = useStore()
		return {
			users: () => store.dispatch('users'),
			unblock_user: (user_id) => store.dispatch('unblock_user', user_id),
			modals: computed(() => store.getters.modals),
		}
	},
	created() {
	},
	mounted() {
        this.$store.commit('UnblockUserModal', new Modal(this.$refs.UnblockUserModal));
	},
	props: {
		user: Object,
	},
	unmounted() {
		this.$store.commit('UnblockUserModal', null);
	},
	computed: {
	},
	methods: {
		unblockUser() {
			this.loading = true;
			this.unblock_user(this.user.id).then(() => {
				this.loading = false;
				this.users();
				this.close();
			});
		},
		close() {
			this.modals.UnblockUserModal.hide();
		},
	}
}
</script>

<template>
	<div class="modal fade modal-md" ref="UnblockUserModal" tabindex="-1" aria-labelledby="unblockUser" aria-hidden="true" @close="close();">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="unblockUser">Desbloquear Usuario</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body" :class="{ 'opacity-50': loading === true }">
					<div class="row">
						<div class="col">
							<p class="mb-0 fs-12">¿Desea desbloquear a <strong>{{ user && user.name ? user.name : '' }}</strong>?</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Cancelar" :disabled="loading">Cancelar</button>
					<button class="btn btn-primary" @click="unblockUser()" :disabled="loading">Confirmar</button>
				</div>
			</div>
		</div>
	</div>
</template>
