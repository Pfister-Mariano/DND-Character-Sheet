<template>
    <div :style="{ 'grid-column': 'auto / span ' + gridColumn, 'grid-row': 'auto / span ' + gridRow }">
        <input type="number" v-model="gridColumn">
        <input type="number" v-model="gridRow">
        <slot />
    </div>
</template>

<script setup>
import { ref } from "vue";
let gridColumn = ref(1);
let gridRow = ref(1);
</script>

<style scoped>
input {
    all: unset;
    font-size: 1.5rem;
    color: white;
}
</style>