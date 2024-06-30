<script setup>
    const props = defineProps({
        show : {
            type: Boolean,
            default: false,
        }
    })

    const emit = defineEmits(['update:show']);    
    
    const handleClick = (e) => {
        console.log(e);
        e.target.setPointerCapture(e.pointerId);
        emit('update:show', false);
    }
</script>

<template>
    <Teleport to="body" v-if="show">
        <div  class="blackArea" @pointerdown="handleClick">
            <div class="mdMainArea" @pointerdown.stop>
                <slot />
            </div>
        </div>
    </Teleport>
</template>
    
<style scoped>
.mdMainArea{
    width: 80%;
    height: 45%;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0px 5px 40px -10px;
}

.blackArea {
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    z-index: 100;
    background-color: rgba(0, 0, 0, .5);
}
</style>