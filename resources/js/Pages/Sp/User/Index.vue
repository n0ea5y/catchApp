<script setup>
    import AuthenticatedLayoutSp from '@/Layouts/AuthenticatedLayoutSp.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { getFrom } from '@/axiosService.js'


    const props = defineProps({
        userList: Object,
    })
    console.log(getFrom('/getSaleData'))

</script>

<template>
    <Head title="CA/UserList" />

    <AuthenticatedLayoutSp>
        <div class="py-6 px-2 mb-10 shadow flex flex-wrap justify-center ">
            <template v-for="item in userList" :key="item.id">
                <Link :href="route('sp.sale.index', { sale: item.id })">
                <div class="rounded-lg mb-10 w-12/12 shadow-lg bg-[#f5fffa]">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">{{ item.name }}</div>
                        <p class="text-gray-700 text-base"></p>
                    </div>
                    <div class="px-6 pt-4 pb-2">
                        <span
                            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                        <span
                            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                        <span
                            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                    </div>
                </div>
                </Link>
            </template>
        </div>


    </AuthenticatedLayoutSp>
</template>

<style>

</style>
