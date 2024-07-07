<script setup>
    const props = defineProps({
        class: {
            type: String,
        }
    })
</script>

<template>
    <div 
        class="py-4 px-4 m-2 shadow border rounded-lg bg-[#f5fffa]"
        :class="props.class">
        <slot />
    </div>
</template>