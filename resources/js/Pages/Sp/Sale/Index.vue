<script setup>
import { ref } from 'vue';
import axios from 'axios';

import AuthenticatedLayoutSp from '@/Layouts/AuthenticatedLayoutSp.vue';
import SalesInputForm from './SalesInputForm.vue';
import TotaleSales from './TotaleSales.vue';

const props = defineProps({
    userId: Number,
})
const id = ref(props.userId);
const storeList = ref([]);
const totalList = ref([]);
const getTotalPayRef = ref(null);

const setUsreId = (item) => {
    id.value = item.userId;
}

const getTotalPay = (item) => {
    const userId = item.userId;
    const month = item.month;

    axios.get(`/user-total-sale?userId=${userId}&month=${month}`)
        .then(function (res) {
            totalList.value = res.data;
        })
        .catch(function (error) {
        })
}

// 店舗取得API
axios.get('/store/getStoreList')
    .then(function (res) {
        storeList.value = res.data;
    })
    .catch(function (error) {
    })

</script>
<template>
    <AuthenticatedLayoutSp>
        <sales-input-form :userId="id" @up-user-id="setUsreId" @action="getTotalPay"/>
        <totale-sales :totalList="totalList" :storeList="storeList" ref="getTotalPayRef"/>
    </AuthenticatedLayoutSp>
</template>
<style scoped>
.selectRowBgColor{
    background-color: #EBF5F0;
}
</style>