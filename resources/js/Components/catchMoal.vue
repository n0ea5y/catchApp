<script setup>
const props = defineProps({
    show: {
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
        <div class="blackArea" >
            <div class="mdMainArea" @pointerdown.stop>

                <div class="flex justify-center my-[20px]">
                    <slot name="modalTitle" />
                </div>

                <div class="close" @pointerdown="handleClick">
                    <span></span>
                    <span></span>
                </div>
                <slot />
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
.mdMainArea {
    position: relative;
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
.close{
    position: relative;
    left: 92%;
    top: -55px;
    height: 20px;
    width: 20px;
}
.close span {
    position: absolute;
    height: 2px;
    width: 20px;
    background-color: black;
    top: 50%;
    left: 50%;

    transform: translate(-50%, -50%) rotate(45deg);
}

.close span:nth-of-type(2){
    transform: translate(-50%, -50%) rotate(-45deg);
}
</style>