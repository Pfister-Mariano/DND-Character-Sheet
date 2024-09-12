<template>
    <Tabs default-value="tab-characterView" class="tab">
        <TabsList class="tabList">
            <TabsTrigger class="tabTrigger" v-for="(view, index) in characterData.views" :key="index" :value="`tab-${index}`">
                {{ view.name }}
            </TabsTrigger>
        </TabsList>
        <TabsContent class="tabContent" v-for="(view, index) in characterData.views" :key="index" :value="`tab-${index}`">
            <viewGrid 
            :gridRows="view.gridRows" 
            :gridColumns="view.gridColumns"
            @update:gridColumnSize="(value) => updateGridView(index, itemIndex, 'gridColumns', value)"
            @update:gridRowSize="(value) => updateGridView(index, itemIndex, 'gridRows', value)"
            >
                <gridContainer 
                    v-for="(item, itemIndex) in view.contents"
                    :key="itemIndex"
                    :columnSize="item.columns"
                    :rowSize="item.row"
                    @update:columnSize="(value) => updateViewContent(index, itemIndex, 'columns', value)"
                    @update:rowSize="(value) => updateViewContent(index, itemIndex, 'row', value)"
                    >
                        <component
                            :key="itemIndex"
                            :is="componentMap[item.type]"
                            :characterData="characterData.character"
                            @update:characterData="(value) => updateCharacterData(index, itemIndex, 'row', value)"
                        />
                </gridContainer>
            </viewGrid>
        </TabsContent>
    </Tabs>

    <button @click="saveCharacterData">SAVE Character Sheet</button>
    <br>
    <br>
    <br>
    <pre>{{ fileList }}</pre>
    <pre>
        {{ characterData }}
    </pre>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

import { fetchData } from './composables/useData.js';
import { postData } from './composables/useData.js';
import { listAllFiles } from './composables/useData.js';

import componentMap from './composables/componentMap.js';
import viewGrid from './components/viewGrid.vue';
import gridContainer from './components/gridContainer.vue';

import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/components/ui/tabs';

const { data, loadData } = fetchData();
const { fileList, loadAllFiles } = listAllFiles();
const { saveData } = postData();

const characterData = ref({});
const filename = `${getQueryParam('character')}.json`;  // Extract filename or default to 'gargamel.json'

function getQueryParam(param) {
    const params = new URLSearchParams(window.location.search);
    return params.get(param);
}

onMounted(async () => {
    await loadData(filename);  // Pass filename to loadData()
    await loadAllFiles();
    characterData.value = data.value;
});

function updateViewContent(index, itemIndex, key, value) {
    characterData.value.views[index].contents[itemIndex][key] = value;
}

function updateGridView(index, itemIndex, key, value) {
    characterData.value.views[index][key] = value;
    console.log(index, key, value);
    console.log(characterData.value.views[index][key]);
}

function updateCharacterData(index, itemIndex, key, value) {
    characterData.character = value;
    console.log('changed character data');
    // saveCharacterData();
}

function saveCharacterData() {
    data.value = characterData.value;
    saveData(filename);
}


/************************************** */
// function addTestComp() {
//     let addedStats =    {
//         "type": "Spellcasting",
//         "row": 7,
//         "columns": 2
//     }     
//     characterData.value.views['characterView'].contents.push(addedStats)
// }
/************************************** */

</script>

<style scoped lang="scss"></style>