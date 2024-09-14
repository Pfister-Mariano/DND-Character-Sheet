<template>
    <main :style="{ 
        'grid-template-columns': 'repeat( ' + props.gridColumns + ', minmax(0, 1fr))', 
        'grid-template-rows': 'repeat( ' + props.gridRows + ', minmax(0, 1fr))'}">
        VIEW Columns: <input 
            type="number" 
            v-model="props.gridColumns" 
            @input="updateGridColumnSize" 
        /><br>
        VIEW Rows: <input 
            type="number" 
            v-model="props.gridRows" 
            @input="updateGridRowSize" 
        />
        <slot></slot>
    </main>
</template>

<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';

const props = defineProps({
    gridRows: {
        type: Number,
        required: true
    },
    gridColumns: {
        type: Number,
        required: true
    }
});

const localGridColumnSize = ref(props.gridColumns);
const localGridRowSize = ref(props.gridRows);

watch(localGridColumnSize, (newVal) => {
    localGridColumnSize.value = newVal;
    props.gridColumns = newVal;
});

watch(localGridRowSize, (newVal) => {
    localGridRowSize.value = newVal;
    props.gridRows = newVal
});

const emit = defineEmits(['update:gridColumnSize', 'update:gridRowSize']);

function updateGridColumnSize(event) {
    const newSize = Number(event.target.value);
    emit('update:gridColumnSize', newSize);
}

function updateGridRowSize(event) {
    const newSize = Number(event.target.value);
    emit('update:gridRowSize', newSize);
}

</script>

<style scoped lang="scss">
    main{
        display: grid;
        // background-color: var(--colorBgCustom);
    }
</style>