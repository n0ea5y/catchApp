<script setup>
import CatchContener from '@/Components/CatchContener.vue'
import CatchTable from '@/Components/CatchTable.vue';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
import { formatSale } from '@/formatList.js'
import { shopMapping } from '@/utils.js'

const props = defineProps({
    totalList: Array,
    storeList: Array,
});

const tableHeader = [
    { 'id': 'shop', 'text': '店舗名' },
    { 'id': 'sale', 'text': '売上トータル' },
    { 'id': 'commission', 'text': '歩合金' },
]
</script>

<template>
    <catch-contener>
        <div class="px-4 py-2 shadow border rounded-lg bg-white">
            <h1 class="font-bold underline">売上トータル</h1>
            <CatchTable>
                <template #tHeader>
                    <th v-for="h in tableHeader" :key="h.id">{{ h.text }}</th>
                </template>

                <template #tData>
                    <tr v-if="totalList.length == 0">
                        <td colspan="3" class="text-center py-2">登録データがありません</td>
                    </tr>
                    <tr v-else class="border-b-2 border-gray-100" v-for="item in totalList" :key="item.id">
                        <td class="text-center py-2">{{ shopMapping(props.storeList, item.stores_id) }}</td>
                        <td class="text-right py-2 pr-5">{{ formatSale(item.total_customer_payment) }}円</td>
                        <td class="text-right py-2 pr-5">{{ formatSale(Math.floor(item.total_customer_payment * (item.stores_id != 2 ? (item.commission / 100) : (18 / 100)))) }}円</td>
                    </tr>
                </template>
            </CatchTable>
        </div>
    </catch-contener>
</template>