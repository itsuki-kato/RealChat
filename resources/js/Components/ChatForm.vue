<script setup>
import { reactive } from 'vue';
import { defineEmits } from 'vue';
import FileInput from '@/Components/FileInput.vue';

const props = defineProps({
    user_id: {
        type: Number,
        required: true
    },
    room_id: {
        type: Number,
        required: true
    }
})

const emit_event_send_message = defineEmits(['send_message'])

const form = reactive({
    content: '',
    file: null,
    user_id: props.user_id,
    room_id: props.room_id,
})

// 入力フォームのバリデーション
const validMessage = () => {
    // どちらかが入力されていたらdisabled=false
    if (form.content || form.file) {
        return false
    } else {
        return true
    }
}

// 親コンポーネントにイベントを送信
const emitMessage = () => {
    const NewMessage = {
        content: form.content,
        user_id: form.user_id,
        room_id: form.room_id
    }
    emit_event_send_message('send_message', NewMessage)

    // フォームをクリア
    form.content = ''
    form.file = null
}
</script>
<template>
    <div class="mt-5 border">
        <FileInput v-model="form.file"></FileInput>
        <v-textarea clearable label="入力してください" variant="solo" v-model="form.content"></v-textarea>
        <v-btn type="submit" block class="mt-2" @click="emitMessage" :disabled="validMessage()">Submit</v-btn>
    </div>
</template>
