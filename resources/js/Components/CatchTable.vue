<script setup>

</script>

<template>
    <div class="h-[300px] overflow-scroll rounded">
        <table class="table-fixed w-full">
            <thead>
                <tr class="sticky top-0 z-10 bg-gray-300">
                    <slot name="tHeader"></slot>
                </tr>
            </thead>
            <tbody>
                <slot name="tData"></slot>
            </tbody>
        </table>
    </div>

</template>
