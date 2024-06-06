<script setup>
import AuthenticatedLayoutSp from '@/Layouts/AuthenticatedLayoutSp.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

onMounted(() => {
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayoutSp>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="px-2 m-1 py-5 rounded shadow-md bg-[#f5fffa]">
            <div class="text-gray-900">すまほだよ〜</div>
            <div class="p-2 rounded shadow-lg">
                <Link :href="route('sp.user.index')">
                <h2>売上登録</h2>
                </Link>
            </div>
        </div>
    </AuthenticatedLayoutSp>
</template>
<style>
</style>