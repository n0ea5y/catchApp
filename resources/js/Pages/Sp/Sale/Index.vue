<script setup>
import AuthenticatedLayoutSp from '@/Layouts/AuthenticatedLayoutSp.vue';
import axios from 'axios';
import { ref, watch, computed, onMounted } from 'vue';
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import CatchTable from '@/Components/CatchTable.vue';
import CatchButton from '@/Components/CatchButton.vue';
import catchMoal from '@/Components/catchMoal.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import { formatSale, formatDate } from '@/formatList.js'
import { shopMapping } from '@/utils.js'

const props = defineProps({
    userDetail: Object,
});

onMounted(() => {
    getSales();
})

const form = useForm({
    store: '',
    sale: '',
    date: '',
});

const saleList = ref([]);
const storeList = ref([]);

const stores_id = ref('');
const customer_payment = ref('');
const created_date = ref('');
const flashMessage = ref('');
const rowIndex = ref(null);
const selectRowData = ref(null);

const addFlag = ref(true);

// 店舗取得API
axios.get('/stores')
    .then(function (response) {
        storeList.value = response.data;
    })
    .catch(function (error) {
    })


// ユーザに紐づく金額取得API
const getSales = () => {
    axios.get(`/sale/getSaleList/${props.userDetail.id}`)
    .then(function (response) {
        saleList.value = response.data;
        console.log(response.data);
    })
    .catch(function (error) {
    })

}

const rowClick = (item) => {
    stores_id.value = item.stores_id;
    customer_payment.value = item.customer_payment;
    created_date.value = formatDate(item.created_date);

    selectRowData.value = item.id
    rowIndex.value  = item.id;
    addFlag.value = false;
}

/**
 * 登録時処理関数
 */
const onAdd = () => {
    axios.post('/sale', {
        users_id: props.userDetail.id,
        stores_id: stores_id.value,
        customer_payment: customer_payment.value,
        created_date: created_date.value,
  })
  .then(function (response) {
    if(response.status == 200 ){
        flashMessage.value = '更新完了しました！'
    }
    getSales();
  })
  .catch(function (error) {
    console.log(error);
  });
}

/**
 * 更新時処理関数
 */
const onEdit = () => {
    axios.post(`/sale/${rowIndex.value}`, {
        users_id: props.userDetail.id,
        stores_id: stores_id.value,
        customer_payment: customer_payment.value,
        created_date: created_date.value,
  })
  .then(function (response) {
    console.log(response.data);
    if(response.status == 200 ){
        flashMessage.value = '更新完了しました！'
    }
    getSales();
  })
  .catch(function (error) {
    console.log(error);
    if(response.status != 200 ){
        flashMessage.value = '更新に失敗しました！'
    }
  });
}

/**
 * 削除時処理関数
 */
const onDelete = () => {
    console.log("削除がクリックされたよ")
}

const onAddMode = () => {
    created_date.value  = '';
    stores_id.value  = '';
    customer_payment.value = '';
    selectRowData.value = '';

    addFlag.value = true;
}

watch(() => flashMessage.value, (newVal) => {
    setTimeout(() => {
        flashMessage.value = '';
    }, 3000)
});
const isEnpteCheck = computed(() => {
    return stores_id.value !== '' && customer_payment.value !== '' && created_date.value !== '';
})

watch(() => isEnpteCheck.value, ((newVal) => {
    console.log(newVal)
})); 
</script>
<template>
    <AuthenticatedLayoutSp>
    </AuthenticatedLayoutSp>
</template>
<style scoped>
.selectRowBgColor{
    background-color: #EBF5F0;
}
</style>