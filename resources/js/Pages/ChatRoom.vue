<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ChatMessage from '@/Components/ChatMessage.vue';
import ChatForm from '@/Components/ChatForm.vue';

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

// TODO:非同期にする
// 入力されたメッセージを送信する
const sendMessage = (form) => {
    Inertia.post(route('chats.store'), form)
}

// コンポーネント作成時に実行する処理
const created = () => {
    // chat-channelイベントに接続してチャット送信イベントを監視
    window.Echo.channel('chat-channel')
    .listen('ChatEvent', (NewMessage)=> {
        // リアクティブなメッセージの配列に新規メッセージを追加
        RefMessages.value.push(NewMessage)
        console.log('broadcast done')
    })
}

created()
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ChatRoom</h2>
        </template>
        <v-container>
            <div class="chat-wrapper">
                <ChatMessage :RefMessages="RefMessages" :room_id="room_id" :user_id="user_id"/>
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
