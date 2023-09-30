<script setup>
import { onMounted } from "vue";
import axios from 'axios';

const props = defineProps({
    Messages: {
        type: Object
    },
    room_id: {
        type: Number,
        required: true
    }
})

// メッセージ取得用メソッド
const getMessages = () => {
    axios.get(`/api/messages/${props.room_id}`)
    .then(res => {
        console.log('success')
        console.log(res.data.message)
    }).catch(error => {
        console.error(error)
    })
}

// コンポーネントマウント時にチャットイベントを参照する
// TODO：コンポーネント分け
onMounted(() => {
    window.Echo.channel('chat-channel')
    .listen('ChatEvent', (e)=> {
       getMessages()
        console.log('broadcast done')
    })
})
</script>
<template>
    <div class="chat-list">
        <p v-for="Message in Messages" :key="Message.user.id" class="chat-item">
            {{ Message.content }} <br> {{ Message.user_id }}
        </p>
    </div>
</template>
