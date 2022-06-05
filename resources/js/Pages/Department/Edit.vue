<template>
    <app-layout>
        <Head title="New Department" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Department
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end py-4 px-8 space-x-4">
                        <Link :href="route('departments.index')" class="underline cursor-pointer">Cancel</Link>
                        <span @click="submit" class="underline" :class="{'text-gray-black cursor-pointer': form.isDirty, 'cursor-not-allowed text-gray-400': !form.isDirty}">Update</span>
                    </div>

                    <div class="px-8 my-16 h-screen ">
                        <form @submit.prevent="submit">
                            <div>
                                <JetLabel for="name" value="Department Name" />
                                <span v-if="form.errors.name" class="text-red-500 text-xs">{{form.errors.name}}</span>
                                <JetInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    :class="{ 'bg-red-50' : form.errors.name }"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                            </div>
                        </form>
                        <div class="mt-16">
                            <h2 class="bold text-2xl border-b-2 border-gray-50 py-2">Items</h2>
                            <div class="space-y-4 divide-y divide-y-gray-50">
                                <div v-for="item in department.items" :key="'item_id_'+item.id" class="list-decimal px-8 py-4 flex justify-between items-center">
                                    <Link class="block">{{ item.name }}</Link>
                                    <span class="underline cursor-pointer text-xs" @click="destroy(item.id)">Delete</span>
                                </div>
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
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import JetInput from '@/Jetstream/Input.vue';
import JetLabel from '@/Jetstream/Label.vue';

const props = defineProps({
    department: Object,
});

const form = useForm({
    name: props.department.name,
});

const submit = () => {
    if ( form.isDirty )
        form.put(route('departments.update', props.department.department_id));
};

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
