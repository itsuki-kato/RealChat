<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { computed, onMounted, reactive, ref } from 'vue';
import FlushMessage from '@/Components/FlashMessage.vue';
import { Head } from '@inertiajs/inertia-vue3';
import FileInput from '@/Components/FileInput.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    Messages: {
        type: Object
    },
    user_id: {
        type: Number,
        required: true,
    },
    room_id: {
        type: Number,
        required: true
    }
})

const form = reactive({
    send_message: '',
    send_file: null,
    send_user_id: props.user_id,
    send_room_id: props.room_id,
})

const validMessage = () => {
    if(form.send_message || form.send_file) {
        return false
    }
    return true
}

const sendMessage = () => {
    Inertia.post(route('chats.store'), form)
}
</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ChatRoom</h2>
        </template>
        <v-container>
            <div class="chat-wrapper">
                <div class="chat-list">
                    <p v-for="Message in Messages" :key="Message.id" class="chat-item">
                        {{ Message.content }}
                    </p>
                </div>
                <div class="mt-5 border">
                    <v-form @submit.prevent="sendMessage">
                        <FileInput v-model="form.send_file"></FileInput>
                        <v-textarea clearable label="Label" variant="solo" v-model="form.send_message"></v-textarea>
                        <v-btn type="submit" block class="mt-2" :disabled="validMessage()">Submit</v-btn>
                    </v-form>
                </div>
            </div>
        </v-container>
    </AuthenticatedLayout>
</template>
<style scoped>
.chat-list {
    height: 500px;
}
.chat-item {
    border: 1px solid black;
}
</style>
