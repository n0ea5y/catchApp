<script setup>
import AuthenticatedLayoutSp from '@/Layouts/AuthenticatedLayoutSp.vue';
import Show from './Show.vue';

const props = defineProps({
    userId: Number,
})

console.log(props.userId);
</script>
<template>
    <AuthenticatedLayoutSp>
        <Show :UserId="userId"></Show>
    </AuthenticatedLayoutSp>
</template>
<style scoped>
.selectRowBgColor{
    background-color: #EBF5F0;
}
</style>