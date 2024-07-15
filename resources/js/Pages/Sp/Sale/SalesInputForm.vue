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
        userId: Number,
    });

    onMounted(() => {
        getStores();
        getUserList();
        getSales(props.userId, month.value);
        emit('action', { 'userId': props.userId, 'month': month.value })
    })

    const emit = defineEmits(['upUserId', 'action'])
    const form = useForm({
        store: 1,
        sale: '',
        date: null,
    });

    const getMonth = () => {
        const today = new Date();
        return today.getMonth() + 1;
    }

    const saleList = ref([]);
    const storeList = ref([]);

    const stores_id = ref(1);
    const customer_payment = ref('');
    const created_date = ref(null);
    const flashMessage = ref('');
    const rowIndex = ref(null);
    const selectRowData = ref(null);
    const modalShow = ref(false);
    const numbers = ref(Array.from({ length: 12 }, (_, i) => i + 1));
    const month = ref(getMonth());
    const addFlag = ref(true);

    const users = ref([]);
    const userId = ref(props.userId);


    // 店舗取得API
    const getStores = () => {
        axios.get('/store/getStoreList')
            .then(function (res) {
                storeList.value = res.data;
            })
            .catch(function (error) {
            })
    }

    // ユーザー一覧取得
    const getUserList = () => {
        axios.get('/getUserList')
            .then(function (res) {
                users.value = res.data;
            })
            .catch(function (error) {
            })
    }

    // ユーザに紐づく金額取得API
    const getSales = (id, month) => {
        axios.get(`/salesData?userId=${id}&month=${month}`)
            .then(function (res) {
                saleList.value = res.data;
            })
            .catch(function (error) {
            })
    }

    const rowClick = (item) => {
        const today = getToDay().split('-').slice(0, 2).join('');
        const createDate = item.created_date.split('-').slice(0, 2).join('');
        if (today > createDate) return;
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
        axios.post('/sp/sale', {
            users_id: userId.value,
            stores_id: stores_id.value,
            customer_payment: customer_payment.value,
            created_date: created_date.value,
        })
            .then(function (response) {
                if (response.status == 200) {
                    flashMessage.value = '更新完了しました！'
                }

                getSales(userId.value, month.value);
                modalShow.value = !modalShow.value;
                emit('action', { 'userId': props.userId, 'month': month.value });
            })
            .catch(function (error) {
            });
    }

    /**
     * 更新時処理関数
     */
    const onEdit = () => {
        axios.put(`/sp/sale/${rowIndex.value}`, {
            users_id: userId.value,
            stores_id: stores_id.value,
            customer_payment: customer_payment.value,
            created_date: created_date.value,
        })
            .then(function (response) {
                if (response.status == 200) {
                    flashMessage.value = '更新完了しました！'
                }
                getSales(userId.value, month.value);
                modalShow.value = !modalShow.value;
                emit('action', { 'userId': props.userId, 'month': month.value });
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
        axios.delete(`/sp/sale/${rowIndex.value}`)
            .then(function (response) {
                if (response.status == 200) {
                    flashMessage.value = '削除完了しました！'
                }
                getSales(userId.value, month.value);
                modalShow.value = !modalShow.value;
                emit('action', { 'userId': props.userId, 'month': month.value });
            })
            .catch(function (error) {
                flashMessage.value = '削除に失敗しました！'
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

    watch(() => userId.value, (newVal) => {
        emit('upUserId', { userId: newVal })
    })

    watch(() => flashMessage.value, (newVal) => {
        setTimeout(() => {
            flashMessage.value = '';
        }, 3000)
    });

    const isEnpteCheck = computed(() => {
        return stores_id.value !== null && customer_payment.value !== null && created_date.value !== null;
    });

    // 今日の火付けを取得する
    const getToDay = () => {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const date = String(today.getDate()).padStart(2, '0');
        const yyyymmdd = `${year}-${month}-${date}`;
        return yyyymmdd;
    }

    // 月変更時にデータ取得
    const chengeMonth = (item) => {
        selectRowData.value = null;
        getSales(props.userId, item.target.value);
        emit('action', { 'userId': props.userId, 'month': item.target.value })

    }
    // ユーザー変更時にデータ取得
    const chengeUser = (item) => {
        selectRowData.value = null;
        getSales(item.target.value, month.value);
        emit('action', { 'userId': item.target.value, 'month': month.value })
    }

    const handleClick = () => {
        modalShow.value = !modalShow.value;
    }

    const tableHeader = [
        { "id": "shop", "text": "店舗" },
        { "id": "date", "text": "日付" },
        { "id": "pay", "text": "売上" },
    ]

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
                        <CatchButton btnType="insert" @click="onAdd">登録</CatchButton>
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

        <div class="py-4 px-4 m-2 shadow border rounded-lg bg-[#f5fffa]">
            <div class="w-full px-4 py-2 shadow border rounded-lg bg-white">
                <div class="flex justify-end mb-[10px]">
                    <select id="month" name="month" class="w-[63px] rounded-lg" v-model="month" @change="chengeMonth">
                        <option>月を選択してください</option>
                        <option class="" v-for="item in numbers" :key="item">{{ item }}</option>
                    </select>

                    <p class="flex text-xl items-center mr-2">月</p>

                    <select id="user" name="user" class="w-[120px] rounded-lg mr-auto" v-model="userId"
                        @change="chengeUser">
                        <option selected style="display:none; color: gray;">ユーザーを選択してください</option>
                        <option class="" v-for="item in users" :key="item" :value="item.id">{{ item.name }}
                        </option>
                    </select>

                    <button @click="onAddMode" class="w-[50px] bg-yellow-200 border rounded">追加</button>
                </div>
                <CatchTable class="h-[300px]">
                    <template #tHeader>
                        <th v-for="h in tableHeader" :key="h.id">{{ h.text }}</th>
                    </template>

                    <template v-if="saleList.length !== 0" #tData>
                        <tr v-for="sale in saleList" :key="sale.id"
                            :class="{ 'selectRowBgColor': selectRowData == sale.id }" class="hover:bg-[#EBF5F0]"
                            @click="rowClick(sale)">
                            <td class="py-2 border text-center">{{ !sale.stores_id ? '' : shopMapping(storeList,
            sale.stores_id) }}</td>
                            <td class="py-2 border text-center">{{ formatDate(sale.created_date) }}</td>
                            <td class="py-2 border text-center">{{ formatSale(sale.customer_payment) }} 円</td>
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