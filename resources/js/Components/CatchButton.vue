<script setup>
import { ref, computed } from 'vue'

    const props =defineProps({
        btnType: {
            type: String,
            default : 'insert',
        },
        disabled: {
            type: Boolean,
            default : false,
        }
    })

    const hovering = ref(false);

    const bgitems = {
        'insert': {
            normal: 'bg-[#ffff84]',
            hover: 'bg-[#539953]',
        } ,
        'edit': {
            normal: 'bg-[#89c4ff]',
            hover: 'bg-[#6b9fdf]',
        } ,
        'delete': {
            normal: 'bg-[#ff8989]',
            hover: 'bg-[#e76767]',
        } ,
    }

</script>

<template>
    <button
        type="btn"
        class="border-2 border-solid mb-2 w-full py-2 rounded-lg text-[#4a4a4a] font-bold"
        :class="[ bgitems[btnType].normal , { 'bg-gray-400 cursor-not-allowed': props.disabled}]"
        :disabled="disabled"
        >
        <slot></slot>
    </button>
</template>
<style scoped>
/* ボタンがホバーされたときの背景色を設定 */
button:hover {
    background-color: bgitems[btnType];
}
</style>