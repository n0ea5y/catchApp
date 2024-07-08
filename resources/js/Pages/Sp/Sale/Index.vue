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
const getTotalPayRef = ref(null);

const setUsreId = (item) => {
    id.value = item.userId;
}
// 店舗取得API
axios.get('/store/getStoreList')
    .then(function (res) {
        storeList.value = res.data;
    })
    .catch(function (error) {
    })

const getTotalPay = () => {
    getTotalPayRef.value.getTotalPay(id.value);
}
    
</script>
<template>
    <AuthenticatedLayoutSp>
        <sales-input-form :userId="id" @up-user-id="setUsreId" @action="getTotalPay"/>
        <totale-sales :userId="id" :storeList="storeList" ref="getTotalPayRef"/>
    </AuthenticatedLayoutSp>
</template>
<style scoped>
.selectRowBgColor{
    background-color: #EBF5F0;
}
</style>