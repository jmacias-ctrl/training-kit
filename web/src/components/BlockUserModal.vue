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
	name: 'BlockUserModal',
	data() {
		return {
			loading: false,
		}
	},
	setup () {
		const store = useStore()
		return {
			users: () => store.dispatch('users'),
			block_user: (user_id) => store.dispatch('block_user', user_id),
			modals: computed(() => store.getters.modals),
		}
	},
	created() {
	},
	mounted() {
        this.$store.commit('BlockUserModal', new Modal(this.$refs.BlockUserModal));
	},
	props: {
		user: Object,
	},
	unmounted() {
		this.$store.commit('BlockUserModal', null);
	},
	computed: {
	},
	methods: {
		blockUser() {
			this.loading = true;
			this.block_user(this.user.id).then(() => {
				this.loading = false;
				this.users();
				this.close();
			});
		},
		close() {
			this.modals.BlockUserModal.hide();
		},
	}
}
</script>

<template>
	<div class="modal fade modal-md" ref="BlockUserModal" tabindex="-1" aria-labelledby="blockUser" aria-hidden="true" @close="close();">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="blockUser">Bloquear Usuario</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body" :class="{ 'opacity-50': loading === true }">
					<div class="row">
						<div class="col">
							<p class="mb-0 fs-12">¿Desea bloquear a <strong>{{ user && user.name ? user.name : '' }}</strong>?</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Cancelar" :disabled="loading">Cancelar</button>
					<button class="btn btn-primary" @click="blockUser()" :disabled="loading">Confirmar</button>
				</div>
			</div>
		</div>
	</div>
</template>
