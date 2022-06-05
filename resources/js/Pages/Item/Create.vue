<template>
    <app-layout>
        <Head title="New Item" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Item
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end py-4 px-8 space-x-4">
                        <Link :href="route('items.index')" class="underline cursor-pointer">Cancel</Link>
                        <span @click="submit" class="underline" :class="{'text-gray-black cursor-pointer': form.isDirty, 'cursor-not-allowed text-gray-400': !form.isDirty}">Save</span>
                    </div>

                    <div class="px-8 my-16 h-screen">
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <JetLabel for="name" value="Item Name" />
                                <span v-if="form.errors.name" class="text-red-500 text-xs">{{form.errors.name}}</span>
                                <JetInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    :class="{ 'bg-red-50' : form.errors.name }"
                                />
                            </div>
                            <div>
                                <JetLabel for="name" value="Department" />
                                <span v-if="form.errors.department_id" class="text-red-500 text-xs">{{form.errors.department_id}}</span>
                                <select v-model="form.department_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm rounded-md shadow-sm"
                                    :class="{ 'bg-red-50' : form.errors.department_id }">
                                    <option value="">Please Select</option>
                                    <template v-for="department in departments" :key="'department_id_'+department.department_id">
                                        <option :value="department.department_id">{{ department.name }}</option>
                                    </template>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetInput from '@/Jetstream/Input.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetLabel from '@/Jetstream/Label.vue';

const props = defineProps({
    departments: Array,
});

const form = useForm({
    name: '',
    department_id: null,
});

const submit = () => {
    if ( form.isDirty )
        form.post(route('items.store'));
};


</script>

<style scoped>

</style>
