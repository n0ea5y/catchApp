<script setup>
import CatchContener from '@/Components/CatchContener.vue'
import CatchTable from '@/Components/CatchTable.vue';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
import { formatSale } from '@/formatList.js'
import { shopMapping } from '@/utils.js'

const props = defineProps({
    userId: Number,
    storeList: Array,
});
onMounted(() => {
    getTotalPay(props.userId);
})

const totalList = ref([]);
watch(() => props.userId, (newVal) => {
    getTotalPay(newVal);
})

const getTotalPay = (userId) => {
    axios.get('/user-total-sale/' + userId)
        .then(function (res) {
            totalList.value = res.data;
        })
        .catch(function (error) {
        })
}

defineExpose({
    getTotalPay
});
const tableHeader = [
    { 'id': 'shop', 'text': '店舗名' },
    { 'id': 'sale', 'text': '売上トータル' },
    { 'id': 'commission', 'text': '歩合金' },
]
const total = () => {
    let totalPay = 0;
    totalList.value.map(function(item){
        totalPay += Math.floor(item.total_customer_payment * (item.commission / 100));
    });
    return totalPay;
}
</script>

<template>
    <catch-contener>
        <div class="px-4 py-2 shadow border rounded-lg bg-white">
            <h1 class="font-bold underline">売上トータル</h1>
            <CatchTable class="h-[200px]">
                <template #tHeader>
                    <th v-for="h in tableHeader" :key="h.id">{{ h.text }}</th>
                </template>

                <template #tData>
                    <tr class="border-b-2 border-gray-100" v-for="item in totalList" :key="item.id">
                        <td class="text-center py-2">{{ shopMapping(props.storeList, item.stores_id) }}</td>
                        <td class="text-right py-2 pr-5">{{ formatSale(item.total_customer_payment) }}円</td>
                        <td class="text-right py-2 pr-5">{{ formatSale(Math.floor(item.total_customer_payment *
                        (item.commission / 100))) }}円</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold bg-gray-300">合計</td>
                        <td colspan="2" class="text-end pr-5">{{ formatSale(total()) }}円</td>
                    </tr>
                </template>
            </CatchTable>
        </div>
    </catch-contener>
</template>