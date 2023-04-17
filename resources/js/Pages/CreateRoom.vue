<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import FileInput from '@/Components/FileInput.vue';

import { computed, reactive, ref } from 'vue';

const form = reactive({
    name: '',
    room_img: null,
    detail: null,
    rules: [
        value => {
          if (value) return true

          return '作成するRoom名を入力してください'
        },
    ]
});

const createRoom = () => {
    Inertia.post(route('rooms.store'), form)
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">CreateRoom</h2>
        </template>

        <v-container>
            <v-sheet class="mx-auto border">
                <v-form @submit.prevent="createRoom">
                    <v-text-field v-model="form.name" :rules="form.rules" label="Room Name"></v-text-field>
                    <v-text-field v-model="form.detail" label="Room Detail"></v-text-field>
                    <FileInput v-model="form.room_img"></FileInput>
                    <v-btn type="submit" block class="mt-2">Submit</v-btn>
                </v-form>
            </v-sheet>
        </v-container>

    </AuthenticatedLayout>
</template>
