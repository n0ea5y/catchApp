<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';

    const props = defineProps({
        userList: Object,
    })

    console.log(props.userList);

</script>

<template>
    <Head title="CA/UserList" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">

            <h2 class="font-semibold text-xl leading-tight py-2">ユーザーリスト</h2>
            <div class="bg-yellow-200 flex px-3 rounded-lg shadow-lg hover:bg-yellow-400 transform transition">
                <Link :href="route('user.create')" method="get" as="button" type="button">ユーザー作成</Link>
            </div>
        </div>
        </template>
        <div class="py-12 px-12 m-2 shadow border rounded-lg flex flex-wrap bg-[#f5fffa]">
            <template v-for="item in userList" :key="item.id">
                <Link :href="route('sale.show', { sale: item.id })">
                <div class="rounded-lg overflow-hidden shadow-lg w-[431px] mx-[10px] my-[10px] hover:bg-[#EBF5F0] test">
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


    </AuthenticatedLayout>
</template>

<style>
.test:hover{
    transform:scale(1.1,1.1);
    transition:.4s all;
}
</style>
