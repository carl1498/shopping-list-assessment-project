<template>
    <app-layout>
        <Head title="Item" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Items
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end py-4 px-8">
                        <Link :href="route('items.create')" class="underline cursor-pointer">Create Item</Link>
                    </div>

                    <div class="px-8 my-16 h-screen space-y-4">
                        <div v-for="department in departments" :key="'department_id_'+department.department_id">
                            <h2 class="bold text-2xl border-b-2 border-gray-50 py-2">{{ department.name }}</h2>
                            <div v-for="item in department.items" :key="'item_id_'+item.item_id" class="list-decimal px-8 py-4 flex justify-between items-center">
                                <Link class="block" :href="route( 'items.show', item.item_id)">{{ item.name }}</Link>
                                <span class="underline cursor-pointer text-xs" @click="destroy(item.item_id)">Delete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import {computed} from "vue";

defineProps({
    departments: Array,
});

const destroy = (id) => {
    axios.delete( route('items.destroy', id), {
      maxRedirects  : 0
    })
    .then( function(response){
        Inertia.reload();
    })
}

</script>

<style scoped>

</style>
