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
	name: 'DeleteTaskModal',
	data() {
		return {
			loading: false,
		}
	},
	setup () {
		const store = useStore()
		return {
			tasks: () => store.dispatch('tasks'),
			delete_task: (user_id) => store.dispatch('delete_task', user_id),
			modals: computed(() => store.getters.modals),
		}
	},
	created() {
	},
	mounted() {
        this.$store.commit('DeleteTaskModal', new Modal(this.$refs.DeleteTaskModal));
	},
	props: {
		task: Object,
	},
	unmounted() {
		this.$store.commit('DeleteTaskModal', null);
	},
	computed: {
	},
	methods: {
		deleteTask() {
			this.loading = true;
			this.delete_task(this.task.id).then(() => {
				this.loading = false;
				this.tasks();
				this.close();
			});
		},
		close() {
			this.modals.DeleteTaskModal.hide();
		},
	}
}
</script>

<template>
	<div class="modal fade modal-md" ref="DeleteTaskModal" tabindex="-1" aria-labelledby="deleteTask" aria-hidden="true" @close="close();">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="deleteTask">Eliminar Tarea</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body" :class="{ 'opacity-50': loading === true }">
					<div class="row">
						<div class="col">
							<p class="mb-0 fs-12">¿Quieres eliminar esta tarea para <strong>{{ task.client && task.client.name ? task.client.name : '**SIN CLIENTE**' }}</strong> el día <strong>{{ task.delivery ? task.delivery : '**SIN FECHA**' }}</strong>?</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Cancelar" :disabled="loading">Cancelar</button>
					<button class="btn btn-danger" @click="deleteTask()" :disabled="loading">Sí, Eliminar</button>
				</div>
			</div>
		</div>
	</div>
</template>
