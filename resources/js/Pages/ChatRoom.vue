<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import ChatMessage from '@/Components/ChatMessage.vue';
import ChatForm from '@/Components/ChatForm.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    Messages: {
        type: Array
    },
    user_id: {
        type: Number,
        required: true,
    },
    room_id: {
        type: Number,
        required: true
    },
})

// 受け取ったPropsをリアクティブに定義
const RefMessages = ref(props.Messages);

// 子コンポーネントから受け取った新規メッセージを追加
const updateMessage = (NewMessage) => {
    console.log(NewMessage, '[ChatRoom]: 子コンポーネントからメッセージを受信')
    RefMessages.value.push(NewMessage.Message)
}

// 入力されたメッセージを送信する
const sendMessage = (NewMessage2) => {
    console.log(NewMessage2)
    Inertia.post(route('chats.store'), NewMessage2)
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
                <ChatMessage @fetch_message="updateMessage" :RefMessages="RefMessages" :room_id="room_id" :user_id="user_id"/>
                <ChatForm @send_message="sendMessage" :user_id="user_id" :room_id="room_id"/>
            </div>
        </v-container>
    </AuthenticatedLayout>
</template>
<style scoped>
.chat-item {
    border: 1px solid black;
}
</style>
