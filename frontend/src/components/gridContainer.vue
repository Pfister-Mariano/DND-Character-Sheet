<template>
    <article :style="{ 'grid-column': 'auto / span ' + localColumnSize, 'grid-row': 'auto / span ' + localRowSize }">
        Columns: <input 
            type="number" 
            v-model="localColumnSize" 
            @input="updateColumnSize" 
        /><br>
        Rows: <input 
            type="number" 
            v-model="localRowSize" 
            @input="updateRowSize" 
        /><br>
        {{ localColumnSize }} {{ localRowSize }} 
        
        <slot></slot>
    </article>
</template>

<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';

// Define props with correct types
const props = defineProps({
    columnSize: {
        type: Number,
        required: true
    },
    rowSize: {
        type: Number,
        required: true
    }
});

// Create local reactive copies of the props
const localColumnSize = ref(props.columnSize);
const localRowSize = ref(props.rowSize);

// Watch for changes in props to update local state
watch(localColumnSize, (newVal) => {
    localColumnSize.value = newVal;
    props.columnSize = newVal;
});

watch(localRowSize, (newVal) => {
    localRowSize.value = newVal;
    props.rowSize = newVal
});

const emit = defineEmits(['update:columnSize', 'update:rowSize']);

function updateColumnSize(event) {
    const newSize = Number(event.target.value);
    emit('update:columnSize', newSize);
    
}

function updateRowSize(event) {
    const newSize = Number(event.target.value);
    emit('update:rowSize', newSize);
}

</script>

<style scoped lang="scss"></style>
