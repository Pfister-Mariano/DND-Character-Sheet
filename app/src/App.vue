<template>
    <h1 v-if="characterData.character">{{ characterData.character.characterName }}</h1>    
    <Tabs default-value="tab-characterView" class="tab" :class="{ 'editViewGrid': editViewGrid }" v-if="characterData.character" v-model="currentTab">
        <div class="tabWrapper">
            <TabsList class="tabList">
                <TabsTrigger class="tabTrigger" v-for="(view, index) in characterData.views" :key="index" :value="`tab-${index}`">
                    {{ view.name }}
                </TabsTrigger>
            </TabsList>
            <div class="generalInfo">
                <div class="infoLevel" ><span>LVL: </span> 
                    <input type="text" v-model="characterData.character.level" @input="saveCharacterData">
                </div>
                <div class="infoClass"><span>Class: </span> 
                    <input type="text" v-model="characterData.character.class" @input="saveCharacterData">
                </div>
                <div class="infoRace"><span>Race: </span> 
                    <input type="text" v-model="characterData.character.race" @input="saveCharacterData">
                </div>
                <div class="infoBackground"><span>Background: </span> 
                    <input type="text" v-model="characterData.character.background" @input="saveCharacterData">
                </div>
                <div class="infoProfBonus"><span>Prof Bonus: </span>
                    <input type="number" v-model="characterData.character.proficiencyBonus" @input="saveCharacterData">
                </div>
            </div>
            <div class="settings" :class="{ 'active': editViewGrid }" @click="editView">
                <svg width="29" height="30" viewBox="0 0 29 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.2481 0H17.7519L18.7507 4.59375C19.6682 4.97461 20.5276 5.47852 21.3058 6.08203L25.7481 4.65234L29 10.3359L25.5507 13.5059C25.6145 13.9922 25.6494 14.4902 25.6494 14.9941C25.6494 15.498 25.6145 15.9961 25.5507 16.4824L29 19.6523L25.7481 25.3359L21.3058 23.9062C20.5276 24.5098 19.6682 25.0137 18.7507 25.3945L17.7519 30H11.2481L10.2493 25.4062C9.3318 25.0254 8.47237 24.5215 7.69423 23.918L3.2519 25.3418L0 19.6582L3.44934 16.4883C3.38546 16.002 3.35062 15.5039 3.35062 15C3.35062 14.4961 3.38546 13.998 3.44934 13.5117L0 10.3418L3.2519 4.6582L7.69423 6.08789C8.47237 5.48438 9.3318 4.98047 10.2493 4.59961L11.2481 0ZM14.5 19.6875C15.7321 19.6875 16.9137 19.1936 17.7849 18.3146C18.6561 17.4355 19.1456 16.2432 19.1456 15C19.1456 13.7568 18.6561 12.5645 17.7849 11.6854C16.9137 10.8064 15.7321 10.3125 14.5 10.3125C13.2679 10.3125 12.0863 10.8064 11.2151 11.6854C10.3439 12.5645 9.85442 13.7568 9.85442 15C9.85442 16.2432 10.3439 17.4355 11.2151 18.3146C12.0863 19.1936 13.2679 19.6875 14.5 19.6875Z" fill="currentColor"/>
                </svg>
            </div>
        </div>
        <TabsContent class="tabContent" v-for="(view, index) in characterData.views" :key="index" :value="`tab-${index}`">
            <viewGrid 
                :id="view.id"
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
                        :tabViewIndex="itemIndex"
                        :tabViewContent="view"
                        :tabViewType="index"
                        @update:characterData="(value) => updateCharacterData(index, itemIndex, 'row', value)"
                        @update:viewData="(value) => updateViewData(index, itemIndex, 'row', value, viewType)"
                    />
                </gridContainer>
            </viewGrid>
        </TabsContent>
    </Tabs>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue';

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

import Sortable from 'sortablejs';

const { data, loadData } = fetchData();
const { fileList, loadAllFiles } = listAllFiles();
const { saveData } = postData();

const characterData = ref({});
const editViewGrid = ref(false);
const currentTab = ref('tab-characterView');

const filename = `${getQueryParam('character')}.json`;
function getQueryParam(param) {
    const params = new URLSearchParams(window.location.search);
    return params.get(param);
}

onMounted(async () => {
    await loadData(filename);
    await loadAllFiles();
    characterData.value = data.value;
    
    nextTick(() => {
        addDragAndDrop()
    });
});

function updateViewContent(index, itemIndex, key, value) {
    characterData.value.views[index].contents[itemIndex][key] = value;
    saveData(filename);
}

function updateGridView(index, itemIndex, key, value) {
    characterData.value.views[index][key] = value;
    saveData(filename);
}

function updateCharacterData(index, itemIndex, key, value) {
    characterData.character = value;
    console.log('UPDATED CHARACTER');
    saveData(filename);
}

function updateViewData(index, itemIndex, key, value, viewType) {
    characterData.value.views[index] = value
    console.log('UPDATED VIEW');
    saveData(filename);
}

function saveCharacterData() {
    data.value = characterData.value;
    saveData(filename);
}

watch(characterData, (newValue, oldValue) => {
    saveData(filename);
/*     const editor = new EditorJS({
        holderId : 'characterName',
    }); */
})
// let sortable;

// function addDragAndDrop() {
//         let el = document.querySelector('main')
//         sortable = new Sortable(el, {
//             swapThreshold: 0.10,
//             animation: 150,
//             disabled: true,
//             store: {
//                 /**
//                  * Get the order of elements. Called once during initialization.
//                  * @param   {Sortable}  sortable
//                  * @returns {Array}
//                  */
//                 get: function (sortable) {
//                     // var order = localStorage.getItem(sortable.options.group.name);
//                     let stripedTab = currentTab.value.slice(4);
//                     var order = characterData.value.views[stripedTab].sortable

//                     return order ? order : [];
//                 },
//                 /**
//                  * Save the order of elements. Called onEnd (when the item is dropped).
//                  * @param {Sortable}  sortable
//                  */
//                 set: function (sortable) {
//                     var order = sortable.toArray();
//                     // localStorage.setItem(sortable.options.group.name, order.join('|'));

//                     let stripedTab = currentTab.value.slice(4);
//                     characterData.value.views[stripedTab].sortable = order;

//                 }
//             }
//         });
// }

// watch(currentTab, (newTab, oldTab) => {
//     nextTick(() => {
//         addDragAndDrop()
//         currentTab.value = newTab;
//         // let stripedTab = currentTab.value.slice(4);
//         // console.log(characterData.value.views[stripedTab].sortable);
//     });
// });

function editView(){
    editViewGrid.value = !editViewGrid.value;
    var state = sortable.option("disabled"); // get
    sortable.option("disabled", !state); // set
}

</script>

<style scoped lang="scss"></style>