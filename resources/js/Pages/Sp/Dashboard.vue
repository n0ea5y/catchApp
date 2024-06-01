<script setup>
import AuthenticatedLayoutSp from '@/Layouts/AuthenticatedLayoutSp.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayoutSp>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">すまほだよ〜</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutSp>
</template>
