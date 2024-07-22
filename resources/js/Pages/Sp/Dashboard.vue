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
        <div class="px-2 m-1 py-5 rounded shadow-md bg-[#f5fffa]">

            

            <div class="h-[80px] mb-5 flex justify-center items-center rounded shadow-lg bg-[#fdf5e6]">
                <Link class="inline-block" :href="route('sp.sale.index')">
                    <h2>売上登録</h2>
                </Link>
            </div>

            <div class="p-2 rounded shadow-lg bg-[#fff]">
                <h2>シフト表</h2>
                <div class="flex justify-center items-center flex-col">
                    <p>開発中</p>
                    <img class="w-full" src="/storage/kaihatutyu.jpeg" alt="">
                </div>
            </div>
        </div>
    </AuthenticatedLayoutSp>
</template>
<style>
</style>

