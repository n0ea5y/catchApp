<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { ref, watch, computed, onMounted } from 'vue';
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import CatchTable from '@/Components/CatchTable.vue';
import CatchButton from '@/Components/CatchButton.vue';
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

const test = () => {
    console.log(`click`)
}

</script>
<template>
    <AuthenticatedLayout>
        <div class="fixed w-full flex justify-center" v-if="flashMessage">
            <p class="py-4 px-10 rounded-lg bg-[#89ff89] text-[#ffffff]">{{ flashMessage }}</p>
        </div>
        <div class="flex py-4 px-4 m-2 shadow border rounded-lg bg-[#f5fffa]">
            <div class="w-8/12 py-12 px-4 m-2 shadow border rounded-lg bg-white">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-10">{{ userDetail.name }}：月売り一覧</h2>
                <CatchTable>
                    <template #tHeader>
                        <th class="py-2 px-5 border">店舗</th>
                        <th class="py-2 px-5 border">売上</th>
                        <th class="py-2 px-5 border">日付</th>
                    </template>
                    <template v-if="saleList.length !== 0" #tData>
                        <tr v-for="sale in saleList" :key="sale.id" :class="{ 'selectRowBgColor': selectRowData == sale.id }" class="hover:bg-[#EBF5F0]" @click="rowClick(sale)">
                            <td class="py-2 px-5 border text-center">{{ shopMapping(storeList, sale.stores_id) }}</td>
                            <td class="py-2 px-5 border text-center">{{ formatSale(sale.customer_payment) }} 円</td>
                            <td class="py-2 px-5 border text-center">{{ formatDate(sale.created_date) }}</td>
                        </tr>
                    </template>
                    <template v-else #tData>
                        <tr>
                            <td  colspan="3" class="py-2 px-5 border text-center text-red-700">登録されていません</td>
                        </tr>
                    </template>
                </CatchTable>
            </div>

            <div class="w-4/12 py-12 px-4 m-2 shadow border rounded-lg bg-white">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-10">売上入力</h2>

                <form @submit.prevent class="w-full">
                    <label for="store">店舗選択</label>
                    <select id="store" name="store" class="w-full rounded-lg mb-4" v-model="stores_id">
                        <option value="" disabled selected style="display:none; color: gray;">店舗を選択してください</option>
                        <option class="" v-for="item in storeList" :key="item" :value="item.value">{{ item.title }}
                        </option>
                    </select>

                     <div class=mb-4>
                        <InputLabel for="sale" value="金額入力" />
                        <TextInput id="sale" type="Number" class="mt-1 block w-full" v-model="customer_payment" placeholder="半角で数値入力" required autofocus/>
                        <InputError class="mt-2" :message="form.errors.sale" />
                    </div>

                    <div class=mb-4>
                        <InputLabel for="date"/>
                        <TextInput id="date" type="Date" class="mt-1 block w-full" v-model="created_date"  required autofocus/>
                        <InputError class="mt-2" :message="form.errors.date" />
                    </div>
                    <div v-if="addFlag" class="flex justify-center">
                        <button type="btn" :class="{ 'bg-gray-400 cursor-not-allowed': !isEnpteCheck }" class="border-2 border-solid mb-2 w-full py-2 rounded-lg bg-[#ffff89] text-[#808080]" @click="onAdd" :disabled="!isEnpteCheck">登録する</button>
                    </div>

                    <div v-else class="flex flex-col lg:flex-row justify-around">
                        <CatchButton btnType="edit" :disabled="!isEnpteCheck"  @click="onEdit">更新</CatchButton>
                        <CatchButton btnType="delete" :disabled="!isEnpteCheck">削除</CatchButton>
                        <CatchButton btnType="insert" :disabled="!isEnpteCheck" @click="onAddMode"  class="hover:bg-[#539953]">追加</CatchButton>

                    </div>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
<style scoped>
.selectRowBgColor{
    background-color: #EBF5F0;
}
</style>