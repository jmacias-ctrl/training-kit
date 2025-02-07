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
	name: 'AddClientModal',
	data() {
		return {
			loading: false,
			client: {
				name: null,
				vatin: null,
				email: null,
				phone: null,
			},
		}
	},
	setup () {
		const store = useStore()
		return {
			clients: () => store.dispatch('clients'),
			add_client: (data) => store.dispatch('add_client', data),
			modals: computed(() => store.getters.modals),
			ui_theme: computed(() => store.getters.system.settings.ui.theme),
		}
	},
	created() {
	},
	mounted() {
        this.$store.commit('AddClientModal', new Modal(this.$refs.AddClientModal));
	},
	unmounted() {
		this.$store.commit('AddClientModal', null);
	},
	computed: {
		val_name() {
			return this.client.name != null && this.client.name.length > 0 ? true : false;
		},
		val_phone() {
			return this.client.phone != null && this.client.phone.length > 0 ? true : null;
		},
		val_email() {
			return this.client.email != null && this.client.email.length > 0 ? true : null;
		},
		val_full() {
			return this.val_name ? true : false;
		},
	},
	methods: {
		reset() {
			this.client.name = null;
			this.client.vatin = null;
			this.client.email = null;
			this.client.phone = null;
		},
		addClient() {
			this.loading = true;
			this.add_client(this.client).then(() => {
				this.loading = false;
				this.reset();
				this.clients();
				this.close();
			});
		},
		close() {
			this.modals.AddClientModal.hide();
		},
	}
}
</script>

<template>
	<div
		class="modal fade modal-md"
		ref="AddClientModal"
		tabindex="-1"
		aria-labelledby="addClient"
		aria-hidden="true"
		@close="reset(); close();"
	>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-name fs-5" id="addClient">Agregar Cliente</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div
					class="modal-body"
					:class="{
						'opacity-50': loading === true
					}"
				>
					<div class="row">
						<div class="col-7">
							<div class="form-floating mb-3">
								<input
									v-model="client.name" 
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
									Nombre de persona o empresa
								</div>
							</div>
						</div>
						<div class="col-5">
							<div class="form-floating mb-3">
								<input
									v-model="client.phone" 
									:class="{
										'is-valid' : val_phone === true,
									}"
									type="text"
									class="form-control"
									id="phone"
								>
								<label for="phone">Teléfono</label>
								<div class="form-text">
									Número fijo o celular
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-floating mb-3">
								<input
									v-model="client.email" 
									:class="{
										'is-valid' : val_email === true,
									}"
									type="text"
									class="form-control"
									id="email"
								>
								<label for="email">Correo electrónico</label>
								<div class="form-text">
									Sin espacios ni símbolos especiales.
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button
						class="btn btn-outline-secondary"
						:disabled="loading"
						@click="close()"
					>Cancelar</button>
					<button
						class="btn"
						:class="{
							'btn-primary' : val_full,
							'btn-secondary' : !val_full
						}"
						@click="addClient()"
						:disabled="!val_full || loading"
					>Agregar</button>
				</div>
			</div>
		</div>
	</div>
</template>
