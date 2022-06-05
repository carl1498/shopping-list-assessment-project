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
                        <span @click="submit" class="underline" :class="{'text-gray-black cursor-pointer': form.isDirty, 'cursor-not-allowed text-gray-400': !form.isDirty}">Save</span>
                    </div>

                    <div class="px-8 my-16 h-screen ">
                        <form @submit.prevent="submit">
                            <div>
                                <JetLabel for="name" value="Department Name" />
                                <span v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</span>
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
import JetLabel from '@/Jetstream/Label.vue';

const form = useForm({
    name: '',
});

const submit = () => {
    if ( form.isDirty )
        form.post(route('departments.store'));
};
</script>

<style scoped>

</style>
