<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue';

// Controllerから渡された値を取得
const props = defineProps({
    Rooms: {
        type: Object
    }
})

// 画像パス(public以降)の生成
const getFilePath = (Room) => {
    return `/storage/room/${Room.user_id}/${Room.file_path}`
}

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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">OtherRooms</h2>
        </template>

        <v-container>
            <div class="mt-5">
                <v-row justify="start">
                    <v-col v-for="Room in Rooms" :key="Room.id" cols="12" sm="4">
                        <v-card width="350">
                            <v-img height="200" :src="getFilePath(Room)"
                                cover class="text-white">
                                <v-toolbar color="rgba(0, 0, 0, 0)" theme="dark">

                                    <v-toolbar-title class="text-h6">
                                        {{ Room.name }}
                                    </v-toolbar-title>

                                </v-toolbar>
                            </v-img>

                            <v-card-text>
                                <div class="font-weight-bold ms-1 mb-2">
                                    {{ Room.user.name }}
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
                    </v-col>
                </v-row>
            </div>
        </v-container>

    </AuthenticatedLayout>
</template>
