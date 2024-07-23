<script setup>
import AuthenticatedLayoutSp from '@/Layouts/AuthenticatedLayoutSp.vue';
import axios from 'axios';
import { ref, watch, computed, onMounted } from 'vue';
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import CatchTable from '@/Components/CatchTable.vue';
import CatchButton from '@/Components/CatchButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { formatSale, formatDate } from '@/formatList.js'

onMounted(() => {
    getUserListAPI();
})

const userDetail = ref({
    name: '',
    email: '',
    stores_id: '',
    password: '',
    tax: '',
    commission: '',
    role: '',
});

const emit = defineEmits(['update:modelValue'])

const storeList = ref([]);
const userList = ref();
const flashMessage = ref('');
const rowIndex = ref(null);
const selectRowData = ref(null);
const addFlag = ref(true);

// 店舗取得API
axios.get('/store/getStoreList')
    .then(function (response) {
        storeList.value = response.data;
    })
    .catch(function (error) {
    })

const rowClick = (item) => {
    userDetail.value = { ...item }

    selectRowData.value = item.id
    rowIndex.value = item.id;
    addFlag.value = false;
}

// ユーザー一覧取得API
const getUserListAPI = () => {
    axios.get('/getUserList')
        .then((res) => {
            console.log(res.data);
            userList.value = res.data;
        })
        .catch((error) => {
            console.log(error)
        })
}

/**
 * 登録時処理関数
 */
const onAdd = () => {
    axios.post('/user', {
        name: userDetail.value.name,
        email: userDetail.value.email,
        stores_id: userDetail.value.stores_id,
        password: userDetail.value.password,
        tax: userDetail.value.tax,
        commission: userDetail.value.commission,
        role: userDetail.value.role,
    })
        .then(function (response) {
            console.log(response)
            if (response.status == 200) {
                flashMessage.value = '更新完了しました！'
            }
            getUserListAPI();
        })
        .catch(function (error) {
            console.log(error);
        });
}

/**
 * 更新時処理関数
 */
const onEdit = () => {
    axios.put(`/user/${rowIndex.value}`, {
        name: userDetail.value.name,
        email: userDetail.value.email,
        stores_id: userDetail.value.stores_id,
        password: userDetail.value.password,
        tax: userDetail.value.tax,
        commission: userDetail.value.commission,
        role: userDetail.value.role,
    })
        .then(function (response) {
            console.log(response.data);
            if (response.status == 200) {
                flashMessage.value = '更新完了しました！'
            }
            getUserListAPI();
        })
        .catch(function (error) {
            console.log(error);
            if (response.status != 200) {
                flashMessage.value = '更新に失敗しました！'
            }
        });
}


/**
 * 削除時処理関数
 */
const onDelete = (item) => {
    axios.delete('/user/' + userDetail.value.id)
        .then((res) => {
            getUserListAPI();
        })
        .catch((error) => {
            console.log(error)
        })
}

const onAddMode = () => {
    userDetail.value = {}
    addFlag.value = true;
}

const isEnpteCheck = computed(() => {
    return userDetail.stores_id !== '' && userDetail.name !== '' && userDetail.email !== '' && userDetail.password !== '' && userDetail.commission !== '' && userDetail.tax !== '' && userDetail.role !== '';
})


watch(() => flashMessage.value, (newVal) => {
    setTimeout(() => {
        flashMessage.value = '';
    }, 3000)
});

</script>
<template>
    <AuthenticatedLayoutSp>

        <div class="fixed w-full flex justify-center" v-if="flashMessage">
            <p class="py-4 px-10 rounded-lg bg-[#89ff89] text-[#ffffff]">{{ flashMessage }}</p>
        </div>
        <div class="flex flex-col py-4 px-2 m-2  border rounded-lg bg-[#f5fffa]">
            <div class="py-5 px-2 m-2 border rounded-lg bg-white">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">キャッチ一覧</h2>
                <CatchTable>
                    <template #tHeader>
                        <th class="py-2 px-5 border">名前</th>
                        <th class="py-2 px-5 border">所属店舗</th>
                    </template>
                    <template v-if="userList !== 0" #tData>
                        <tr v-for="user in userList" :key="user.id"
                            :class="{ 'selectRowBgColor': selectRowData == user.id }" class="hover:bg-[#EBF5F0]"
                            @click="rowClick(user)">
                            <td class="py-2 px-5 border text-center">{{ user.name }}</td>
                            <td class="py-2 px-5 border text-center">{{ user.store_name }} </td>
                        </tr>
                    </template>
                    <template v-else #tData>
                        <tr>
                            <td colspan="3" class="py-2 px-5 border text-center text-red-700">登録されていません</td>
                        </tr>
                    </template>
                </CatchTable>
            </div>

            <div class="py-12 px-4 m-2 shadow border rounded-lg bg-white">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-10">キャッチ情報入力</h2>

                <form @submit.prevent class="w-full">

                    <select id="stores_id" name="stores_id" v-model="userDetail.stores_id"
                        class="w-full rounded-lg mb-4">
                        <option value="" disabled selected style="display:none; color: gray;">店舗を選択してください</option>
                        <option class="" v-for="item in storeList" :key="item" :value="item.value">{{ item.title }}
                        </option>
                    </select>

                    <div class=mb-4>
                        <InputLabel for="name" value="名前" />
                        <TextInput id="name" type="Text" class="mt-1 block w-full" v-model="userDetail.name"
                            placeholder="半角で数値入力" required autofocus />
                    </div>

                    <div class=mb-4>
                        <InputLabel for="email" value="メールアドレス" />
                        <TextInput id="email" type="Email" class="mt-1 block w-full" v-model="userDetail.email"
                            placeholder="半角で数値入力" required autofocus />
                    </div>

                    <div v-if="addFlag" class=mb-4>
                        <InputLabel for="password" value="パスワード" />
                        <TextInput id="password" type="Password" class="mt-1 block w-full" v-model="userDetail.password"
                            placeholder="半角で数値入力" required autofocus />
                        <InputError class="mt-2" />
                    </div>

                    <label for="tax">税込みOR税抜き</label>
                    <select id="tax" name="tax" v-model="userDetail.tax" class="w-full rounded-lg mb-4">
                        <option value="" disabled selected style="display:none; color: gray;">選択してください</option>
                        <option value="0">税抜き</option>
                        <option value="1">税込み</option>
                    </select>

                    <label for="commission">歩合％</label>
                    <select id="commission" name="commission" v-model="userDetail.commission"
                        class="w-full rounded-lg mb-4">
                        <option value="" disabled selected style="display:none; color: gray;">選択してください</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                    </select>

                    <label for="role">権限</label>
                    <select id="role" name="role" v-model="userDetail.role" class="w-full rounded-lg mb-4">
                        <option value="" disabled selected style="display:none; color: gray;">選択してください</option>
                        <option value="0">閲覧のみ</option>
                        <option value="1">管理者</option>
                    </select>

                    <div v-if="addFlag" class="flex justify-center">
                        <button type="btn" :class="{ 'bg-gray-400 cursor-not-allowed': !isEnpteCheck }"
                            class="border-2 border-solid mb-2 w-full py-2 rounded-lg bg-[#ffff89] text-[#808080]"
                            @click="onAdd" :disabled="!isEnpteCheck">登録する</button>
                    </div>

                    <div v-else class="flex flex-col lg:flex-row justify-around">
                        <CatchButton btnType="edit" :disabled="!isEnpteCheck" @click="onEdit">更新</CatchButton>
                        <CatchButton btnType="delete" :disabled="!isEnpteCheck" @click="onDelete">削除</CatchButton>
                        <CatchButton btnType="insert" @click="onAddMode" class="hover:bg-[#539953]">追加</CatchButton>
                    </div>

                </form>
            </div>
        </div>


    </AuthenticatedLayoutSp>
</template>
<style scoped>
.selectRowBgColor {
    background-color: #EBF5F0;
}
</style>