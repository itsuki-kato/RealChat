<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    stringRoute: String
})

// 指定のURLにgetで遷移する
const back = () => {
    Inertia.get(route(stringRoute))
}

</script>
<template>
    <Link :href="route(stringRoute)">
        <slot />
    </Link>
</template>
