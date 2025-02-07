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
	name: 'LogoutView',
	data() {
		return {
		}
	},
	setup () {
		const store = useStore()
		return {
			logout: () => store.dispatch('logout'),
			ui_theme: computed(() => store.getters.system.settings.ui.theme),
		}
	},
	created() {
		this.logout()
		.then(() => {
			this.$router.push({ name: 'Login' });
		})
		.catch(() => {
			this.$router.push({ name: 'Login' });
		})
	},
}
</script>

<template>
	<div class="container text-center">
		<p class="fs-15 pt-5 mb-4" :class="{ 'text-white' : ui_theme === 'dark', 'text-secondary' : ui_theme === 'light' }">Saliendo</p>
		<div class="spinner-grow text-secondary" role="status"></div>
	</div>
</template>