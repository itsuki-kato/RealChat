<script setup>
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
</script>
<template>
    <div class="chat-list">
        <p v-for="RefMessage in RefMessages" :key="RefMessage.id" class="chat-item">
            {{ RefMessage.content }} <br> {{ RefMessage.user_id }}
        </p>
    </div>
</template>
