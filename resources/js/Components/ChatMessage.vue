<script setup>
import { onMounted } from "vue";
import { defineEmits } from "vue";
import axios from 'axios';

const props = defineProps({
    RefMessages: {
        type: Object
    },
    room_id: {
        type: Number,
        required: true
    },
    user_id: {
        type: Number,
        required: true
    }
})

const emit_event = defineEmits(['fetch_message'])

// メッセージ取得用メソッド
// TODO:意味をしっかり理解する
const getMessage = () => {
    return new Promise((resolve, reject) => {
        axios.get('/api/messages',{
            params: {
                room_id: props.room_id,
                user_id: props.user_id,
            }
        })
        .then(res => {
            resolve(res.data)
        }).catch(error => {
            reject(error)
        })
    })
}

// コンポーネントマウント時にチャットイベントを参照する
// TODO:おそらく親コンポーネントに定義した方がいい
onMounted(() => {
    window.Echo.channel('chat-channel')
    .listen('ChatEvent',  async(e)=> {
        const NewMessage = await getMessage()
        emit_event('fetch_message', NewMessage)
        console.log('[ChatMessage]: 親コンポーネントへメッセージを送信')
        console.log('broadcast done')
    })
})
</script>
<template>
    <div class="chat-list">
        <p v-for="RefMessage in RefMessages" :key="RefMessage.id" class="chat-item">
            {{ RefMessage.content }} <br> {{ RefMessage.user_id }}
        </p>
    </div>
</template>
