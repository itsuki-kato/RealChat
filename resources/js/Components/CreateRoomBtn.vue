<script setup>
import { Link } from "@inertiajs/vue3"

defineProps({
    href : {
        type: String,
        required: true
    }
})
</script>

<template>
    <Link :href="href">
        <v-col cols="auto">
            <v-btn icon="mdi-plus" size="small"></v-btn>
        </v-col>
    </Link>
</template>
