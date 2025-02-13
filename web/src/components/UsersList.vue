<script>
import { useStore } from 'vuex'
import { computed } from 'vue'

export default{
    name: 'UsersList',
    data(){
        return{
            loading: false,
        }
    },
    setup(){
        const store = useStore()
        return {
            users_list: computed(() => store.getters.users_list),
            users_online: computed(() => store.getters.users_online),
            update_users_list: () => store.dispatch('users_list')
        }
    },
    created(){
        this.update_users_list();
    },
}
</script>

<template>
    <div class="container-sm mt-5">
        <div class="card border" style="height:100%; overflow-y: auto;">
            <div class="card-header">
                <h1 class="fs-5">Usuarios</h1>
            </div>
            <div class="card-body">
                <ul class="list-group" v-for="(item, index) in users_list.items" :key="index">
                    <li class="list-group-item" :id="item.id">{{item.name}} <span :class="{ 'text-danger': !item.online, 'text-success': item.online}">
                        <strong v-if="item.online">En Línea</strong>
                        <strong v-if="!item.online">Desconectado</strong>
                    </span> </li>
                </ul>
            </div>
            
        </div>
    </div>
</template>