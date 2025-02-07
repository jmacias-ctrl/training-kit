/*
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
*/

import './scss/custom.scss';
import './assets/main.css';
import { createApp } from 'vue';
import { createStore } from 'vuex';
import App from './App.vue';
import router from './router';
import storefiles from './store';
import api from './api.js';
import * as bootstrap from 'bootstrap';

const store = createStore(storefiles);
const app = createApp(App);
app.config.globalProperties.$api = api;

api.interceptors.response.use(
	(response) => {
		return response;
	},
	(error) => {
		if (error.response && error.response.status == 401) {
			router.push({ name: 'Logout' });
		}
		return Promise.reject(error);
	}
);

router.beforeEach((to, from, next) => {
	if (to.meta.scope === 'any') {
		next();
	} else if (to.meta.scope === 'private') {
		store.getters.session.api.refresh_token != null ? next() : next({ name: 'Login' });
	} else if (to.meta.scope === 'public') {
		store.getters.session.api.refresh_token != null ? next({ name: 'Home' }) : next();
	} else {
		next({ name: 'Home' });
	}
});

app.use(router);
app.use(store);

app.mount('#eniwer');