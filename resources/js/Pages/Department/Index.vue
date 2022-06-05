<template>
    <app-layout>
        <Head title="Department" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Departments
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end py-4 px-8">
                        <Link :href="route('departments.create')" class="underline cursor-pointer">Create Department</Link>
                    </div>

                    <ol class="px-8 my-16 h-screen space-y-4 divide-y divide-y-gray-50">
                        <li v-for="department in departments" class="list-decimal px-8 py-4 flex justify-between items-center">
                            <Link class="block" :href="route( 'departments.show', department)" >{{department.name}}</Link>
                            <span class="underline cursor-pointer text-xs" @click="destroy(department.id)">Delete</span>
                        </li>

                    </ol>
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

    axios.delete( route('departments.destroy', id), {
      maxRedirects  : 0
    }  )
        .then( function(response){
            Inertia.reload();
        } )
}

</script>

<style scoped>

</style>
