<template>
    <Button @click="switchDraggable()">Switch draggable disable</Button>
    <br><br>
    <br><br>
    <input type="number" v-model="gridColumnCount">
    <br><br>
    <br><br>
    <div class="gridWrapper" ref="sortingList"
        :style="{ 'grid-template-columns': 'repeat(' + gridColumnCount + ', minmax(0, 1fr))' }">
        <DragContainer v-for="(item, index) in 8">
            {{ index + 1 }}
        </DragContainer>
    </div>
    <br>
    <br>
    <br>
    <br>
    <EditData/>
</template>

<script setup>
import EditData from './components/EditData.vue'
import DragContainer from './components/DragContainer.vue'
import { Button } from '@/components/ui/button'
import { onMounted, ref, useTemplateRef } from "vue";

import Sortable from 'sortablejs';

let gridColumnCount = ref(4);

let gridSortingList = useTemplateRef('sortingList');
let sortingList = ref(null);
let sortableList;

function switchDraggable() {
    if (sortableList) {
        let state = sortableList.option("disabled"); // get current state
        sortableList.option("disabled", !state); // toggle state
    }
}

onMounted(() => {
    sortableList = new Sortable(gridSortingList.value, {
        swapThreshold: 0.60,
        animation: 150,
        disabled: false,
        store: {
            /**
             * Get the order of elements. Called once during initialization.
             * @param   {Sortable}  sortable
             * @returns {Array}
             */
            get: function (sortable) {
                var order = localStorage.getItem(sortable.options.group.name);
                return order ? order.split('|') : [];
            },

            /**
             * Save the order of elements. Called onEnd (when the item is dropped).
             * @param {Sortable}  sortable
             */
            set: function (sortable) {
                var order = sortable.toArray();
                localStorage.setItem(sortable.options.group.name, order.join('|'));
            }
        }
    });
});
</script>

<style scoped lang="scss" >
.gridWrapper {
    display: grid;
    /* grid-template-columns: repeat(v-bind(gridColumnCount), minmax(0, 1fr)); */
    grid-template-rows: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    width: 100%;
    background-color: rgb(174 187 215);
    font-size: 2rem;
}

.gridWrapper>div {
    background: darkred;
    min-height: 150px;
    width: auto;
}
</style>
