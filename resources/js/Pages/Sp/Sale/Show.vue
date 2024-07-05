<script setup>
import axios from 'axios';
import { ref, watch, computed, onMounted } from 'vue';
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import CatchTable from '@/Components/CatchTable.vue';
import CatchButton from '@/Components/CatchButton.vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';

import { formatSale, formatDate } from '@/formatList.js'
import { shopMapping } from '@/utils.js'

const props = defineProps({
    userDetail: Object,
});

onMounted(() => {
    getSales();
})

const form = useForm({
    store: 1,
    sale: '',
    date: null,
});

const saleList = ref([]);
const storeList = ref([]);

const stores_id = ref(1);
const customer_payment = ref('');
const created_date = ref(null);
const flashMessage = ref('');
const rowIndex = ref(null);
const selectRowData = ref(null);
const modalShow = ref(false);

const addFlag = ref(true);

// 店舗取得API
axios.get('/store/getStoreList')
    .then(function (res) {
        storeList.value = res.data;
    })
    .catch(function (error) {
    })


// ユーザに紐づく金額取得API
const getSales = () => {
    axios.get(`/sale/getSaleList/${props.userDetail.id}`)
        .then(function (response) {
            saleList.value = response.data;
        })
        .catch(function (error) {
        })
}

const rowClick = (item) => {
    stores_id.value = item.stores_id;
    customer_payment.value = item.customer_payment;
    created_date.value = formatDate(item.created_date);
    selectRowData.value = item.id
    rowIndex.value = item.id;
    addFlag.value = false;
    modalShow.value = !modalShow.value;
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
            if (response.status == 200) {
                flashMessage.value = '更新完了しました！'
            }
            getSales();
            modalShow.value = !modalShow.value;
        })
        .catch(function (error) {
        });
}

/**
 * 更新時処理関数
 */
const onEdit = () => {
    axios.put(`/sale/${rowIndex.value}`, {
        users_id: props.userDetail.id,
        stores_id: stores_id.value,
        customer_payment: customer_payment.value,
        created_date: created_date.value,
    })
        .then(function (response) {
            if (response.status == 200) {
                flashMessage.value = '更新完了しました！'
            }
            getSales();
            modalShow.value = !modalShow.value;

        })
        .catch(function (error) {
            if (response.status != 200) {
                flashMessage.value = '更新に失敗しました！'
            }
        });
}

/**
 * 削除時処理関数
 */
const onDelete = () => {
    const isCheck = confirm("削除しますか？")
    if (!isCheck) return;
    axios.delete(`/sale/${rowIndex.value}`)
        .then(function (response) {
            if (response.status == 200) {
                flashMessage.value = '削除完了しました！'
            }
            getSales();
            modalShow.value = !modalShow.value;

        })
        .catch(function (error) {
            if (response.status != 200) {
                flashMessage.value = '削除に失敗しました！'
            }
        });
}

const onAddMode = () => {
    created_date.value = getToDay();
    stores_id.value = 1;
    customer_payment.value = '';
    selectRowData.value = null;
    addFlag.value = true;
    modalShow.value = !modalShow.value;
}

watch(() => flashMessage.value, (newVal) => {
    setTimeout(() => {
        flashMessage.value = '';
    }, 3000)
});
const isEnpteCheck = computed(() => {
    return stores_id.value !== null && customer_payment.value !== null && created_date.value !== null;
})


const getToDay = () => {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const date = String(today.getDate()).padStart(2, '0');
    const yyyymmdd = `${year}-${month}-${date}`;
    return yyyymmdd;
}

const handleClick = () => {
    modalShow.value = !modalShow.value;
}
</script>
<template>
    <Modal :show="modalShow">
        <div class="close" @pointerdown="handleClick">
            <span></span>
            <span></span>
        </div>
        <div class="flex flex-col items-center h-full px-5 mt-[-30px]">
            <h2 class="my-5">売上追加</h2>

            <form @submit.prevent class="w-full">
                <label for="store">店舗選択</label>
                <select id="store" name="store" class="w-full rounded-lg mb-4" v-model="stores_id">
                    <option value="" disabled selected style="display:none; color: gray;">店舗を選択してください</option>
                    <option class="" v-for="item in storeList" :key="item" :value="item.value">{{ item.title }}
                    </option>
                </select>

                <div class=mb-5>
                    <InputLabel for="sale" value="金額入力" />
                    <TextInput id="sale" type="Number" class="mt-1 block w-full" v-model="customer_payment"
                        placeholder="半角で数値入力" required />
                    <InputError class="mt-2" :message="form.errors.sale" />
                </div>

                <div class=mb-4>
                    <InputLabel for="date" />
                    <TextInput id="date" type="Date" class="mt-1 block w-full" v-model="created_date" required />
                    <InputError class="mt-2" :message="form.errors.date" />
                </div>
                <div v-if="addFlag" class="flex justify-center">
                    <button type="btn" :class="{ 'bg-gray-400 cursor-not-allowed': !isEnpteCheck }"
                        class="border-2 border-solid mb-2 w-full py-2 rounded-lg bg-[#ffff89] text-[#808080]"
                        @click="onAdd" :disabled="!isEnpteCheck">登録する</button>
                </div>

                <div v-else class="flex flex-col lg:flex-row justify-around">
                    <CatchButton btnType="edit" :disabled="!isEnpteCheck" @click="onEdit">更新</CatchButton>
                    <CatchButton btnType="delete" :disabled="!isEnpteCheck" @click="onDelete">削除</CatchButton>

                </div>
            </form>
        </div>
    </Modal>
    <div class="fixed w-full flex justify-center" v-if="flashMessage">
        <p class="py-4 px-10 rounded-lg bg-[#89ff89] text-[#ffffff]">{{ flashMessage }}</p>
    </div>

    <div class="flex py-4 px-4 m-2 shadow border rounded-lg bg-[#f5fffa]">
        <div class="px-4 py-2 shadow border rounded-lg bg-white">
            <div class="flex justify-between items-center">
                <h4 class="font-semibold text-lg text-gray-800 leading-tight mb-2">{{ userDetail.name }}：月売り一覧</h4>
                <CatchButton btnType="insert" @click="onAddMode" class="hover:bg-[#539953] w-[100px]">追加 </CatchButton>
            </div>
            <CatchTable>

                <template #tHeader>
                    <th class="py-2 px-5 border">店舗 </th>
                    <th class="py-2 px-5 border">売上</th>
                    <th class="py-2 px-5 border">日付</th>
                </template>
                <template v-if="saleList.length !== 0" #tData>
                    <tr v-for="sale in saleList" :key="sale.id"
                        :class="{ 'selectRowBgColor': selectRowData == sale.id }" class="hover:bg-[#EBF5F0]"
                        @click="rowClick(sale)">
                        <td class="py-2 px-5 border text-center">{{ shopMapping(storeList, sale.stores_id) }}</td>
                        <td class="py-2 px-5 border text-center">{{ formatSale(sale.customer_payment) }} 円</td>
                        <td class="py-2 px-5 border text-center">{{ formatDate(sale.created_date) }}</td>
                    </tr>
                </template>
                <template v-else #tData>
                    <tr>
                        <td colspan="3" class="py-2 px-5 border text-center text-red-700">登録されていません</td>
                    </tr>
                </template>
            </CatchTable>
        </div>
    </div>
</template>
<style scoped>
.selectRowBgColor {
    background-color: #EBF5F0;
}

.close {
    position: relative;
    top: 10px;
    left: 90%;
    height: 30px;
    width: 30px;
}

.close span {
    position: absolute;

    height: 3px;
    width: 34px;
    background-color: black;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
}

.close span:nth-of-type(2) {
    transform: translate(-50%, -50%) rotate(-45deg);
}
</style>