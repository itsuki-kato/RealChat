<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Head } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import { computed, reactive } from 'vue';
import FlushMessage from '@/Components/FlashMessage.vue';

// Controllerから渡された値を取得
const props = defineProps({
    UserRooms: {
        type: Object
    }
})

// 画像パス(public以降)の生成
const getFilePath = (UserRoom) => {
    return `/storage/room/${UserRoom.user_id}/${UserRoom.room.file_path}`
}

// セッションからフラッシュメッセージを取得
const message = computed(() => usePage().props.value.flash.message)

const messages = reactive([
    {
        from: 'You',
        message: `Sure, I'll see you later.`,
        time: '10:42am',
        color: 'deep-purple-lighten-1',
    },
    {
        from: 'John Doe',
        message: 'Yeah, sure. Does 1:00pm work?',
        time: '10:37am',
        color: 'green',
    },
    {
        from: 'You',
        message: 'Did you still want to grab lunch today?',
        time: '9:47am',
        color: 'deep-purple-lighten-1',
    },
]);


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">UserRooms</h2>
        </template>

        <!-- FlushMessage -->
        <FlushMessage :message="message"></FlushMessage>

        <v-container>
            <div class="mt-5">
                <v-row justify="start">
                    <v-col v-for="UserRoom in UserRooms" :key="UserRoom.id" cols="12" sm="4">
                        <Link :href="route('chats.index')">
                            <v-card width="350">
                                <v-img height="200" :src="getFilePath(UserRoom)"
                                    cover class="text-white">
                                    <v-toolbar color="rgba(0, 0, 0, 0)" theme="dark">

                                        <v-toolbar-title class="text-h6">
                                            {{ UserRoom.room.name }}
                                        </v-toolbar-title>

                                    </v-toolbar>
                                </v-img>

                                <v-card-text>
                                    <div class="font-weight-bold ms-1 mb-2">
                                        {{ UserRoom.user.name }}
                                    </div>

                                    <v-timeline density="compact" align="start">
                                        <v-timeline-item v-for="message in messages" :key="message.time"
                                            :dot-color="message.color" size="x-small">
                                            <div class="mb-4">
                                                <div class="font-weight-normal">
                                                    <strong>{{ message.from }}</strong> @{{ message.time }}
                                                </div>
                                                <div>{{ message.message }}</div>
                                            </div>
                                        </v-timeline-item>
                                    </v-timeline>
                                </v-card-text>
                            </v-card>
                        </Link>
                    </v-col>
                </v-row>
            </div>
        </v-container>

    </AuthenticatedLayout>
</template>
