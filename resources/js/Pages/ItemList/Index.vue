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
                    <div class="rounded-xl bg-gray-50 border-gray-200 border my-16 mx-8 px-4 py-4">
                        <h2 class="text-lg text-bold border-b border-gray-200 py-2 px-2 mb-2">
                            Add Item To Shopping List
                        </h2>
                        <div class="flex">
                            <div class="w-1/2">
                                <select v-model="form.item_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                    <option value="">Please Select</option>
                                    <template v-for="department in departments" :key="'department_id_'+department.id">
                                        <option disabled="">{{ department.name }}</option>
                                        <template v-for="item in department.items" :key="'item_id_'+item.id">
                                            <option :value="item.id">{{ item.name }}</option>
                                        </template>
                                    </template>
                                </select>
                            </div>
                            <div class="w-1/2 flex justify-between px-8">
                                <div class="w-1/4">
                                    <input v-model="form.quantity" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" type="number" required placeholder="1">
                                </div>
                                <div class="w-1/4 flex items-center">
                                    <span @click="submit" class="underline" :class="{'text-gray-black cursor-pointer': form.isDirty, 'cursor-not-allowed text-gray-400': !form.isDirty}">Save</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 my-16 space-y-8 h-screen">
                        <div v-for="(itemList, departmentName ) in itemLists" :key="'item_list_department_'+departmentName">
                            <h2 class="bold text-2xl border-b-2 border-gray-50 py-2">{{ departmentName }}</h2>
                            <div class="space-y-4 divide-y divide-y-gray-50">
                                <div v-for="item in itemList.items" :key="'item_list_id_'+item.id" 
                                    :class="{ 'opacity-25' : item.purchased }"
                                    class="list-decimal px-8 py-4 flex justify-between items-center">
                                    <div class="w-1/2 flex items-center">
                                        <div class="w-1/2 flex items-center space-x-4">
                                            <input type="checkbox" name="purchased"
                                                :checked="item.purchased"
                                                v-model="item.purchased"
                                                @change="purchaseCheck(item)">
                                            <label class="block">{{ item.name }}</label>
                                        </div>
                                        <div class="w-1/2">
                                            <input v-model="item.quantity" 
                                                @focus="currentQuantityField.oldValue = item.quantity"
                                                @blur="updateQuantity(item)" 
                                                :class="{ 'bg-red-50' : item.quantity < 0 }"
                                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" type="number" required placeholder="1">
                                            <span v-if="item.quantity < 0" class="text-red-500 text-xs">Quantity cannot be less than 0, this will not save</span>
                                        </div>
                                    </div>
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
import {computed} from "vue";

const props = defineProps({
    departments: Array,
    itemLists: Object,
});

const form = useForm({
    item_id: null,
    quantity: 1,
});

const currentQuantityField = useForm({
    oldValue: null
});

const destroy = (id) => {

    axios.delete( route('list.destroy', id), {
      maxRedirects  : 0
    }  )
        .then( function(response){
            Inertia.reload();
        } )
}

const submit = () => {
    if ( form.isDirty )
        axios.post(route('list.store', form), {
            maxRedirects : 0
        })
        .then (function($response) {
            Inertia.reload();
        });
};

const purchaseCheck = function(item) {
    const updatedValues = {
        purchased: event.target.checked
    };

    updateItemList(item.id, updatedValues);
};

const updateQuantity = function(item) {
    const updatedValues = {
        quantity: event.target.value
    };
    
    if (currentQuantityField.oldValue != event.target.value && event.target.value > -1) {
        updateItemList(item.id, updatedValues);
    }
};

const updateItemList = function(id, updatedValues) {
    axios.put(route('list.update', [id, updatedValues]),{
        maxRedirects  : 0
    })
    .then(function(response){
        Inertia.reload();
    } );
}

</script>

<style scoped>

</style>
