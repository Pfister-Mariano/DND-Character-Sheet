<template>
    <div>
        <div class="noteTabs">
            <div class="noteControl" v-for="(note, index) in localCharacter.notes" :class="currentActiveTab(index)" @click="changeCurrentTab(index)">
                <span>{{ index+1 }}</span>
            </div>
            <div class="noteAdd" @click="addNote()">
                <span><i class="fa-solid fa-plus"></i></span>
            </div>
            <div class="noteRemove" @click="removeNote()">
                <span><i class="fa-solid fa-x"></i></span>
            </div>
        </div>
        <div class="noteContent" v-for="(noteContent, index) in localCharacter.notes">
            <ckEditorBig v-if="index == openTab" :editorText="noteContent" @update:editorText="(newContent, index) => updateText(newContent, index)"/>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';
import ckEditorBig from '../ckEditorBig.vue';

const props = defineProps({
    characterData: {
        type: Object,
        required: true
    },
    tabViewIndex: {
        type: Number,
        required: true
    },
    tabViewContent: {
        type: String,
        required: true
    }
});

let openTab = ref(props.tabViewContent.contents[props.tabViewIndex].openNoteTab)
const localCharacter = ref(props.characterData);

watch(localCharacter, (newVal) => {
    localCharacter.value = newVal;
    props.characterData = newVal
});

const emit = defineEmits(['update:characterData', 'update:viewData']);

function updateCharacterData() {
    emit('update:characterData');
}

function currentActiveTab(index) {
    if (index == props.tabViewContent.contents[props.tabViewIndex].openNoteTab) {
        return 'activeTab'
    }
}

function updateText(newContent, index){
    localCharacter.value.notes[openTab.value] = newContent.value;
    emit('update:characterData');
}

function changeCurrentTab(index) {
    props.tabViewContent.contents[props.tabViewIndex].openNoteTab = index;
    openTab.value = index
    emit('update:viewData', props.tabViewContent);
}

function addNote() {
    localCharacter.value.notes.push('')
    emit('update:characterData');
}

function removeNote() {
    localCharacter.value.notes.splice(openTab.value, 1)
    changeCurrentTab(0)
}
</script>

<style scoped lang="scss">
.noteTabs {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 5px 80px 5px 10px;
    align-items: center;
    background-color: var(--colorBG3);
    border-radius: 6px;

    .noteControl {
        background-color: var(--colorWhite);
        color: var(--colorBG1);
        border-radius: 6px;
        padding: 3px;
        width: 25px;
        text-align: center;
        &.activeTab{
            background-color: var(--colorBlueDark);
            color: var(--colorWhite);
        }
    }
}
.noteContent{
    height: 100%;
    >div{
        padding-top: 50px;
    }
}
.noteRemove,
.noteAdd{
    background-color: var(--colorDisadvantage);
    color: var(--colorWhite);
    border-radius: 50%;
    padding: 3px;
    width: 25px;
    text-align: center;
    position: absolute;
    right: 10px;
}
.noteAdd{
    background-color: var(--colorAdvantage);
    right: 45px;
}
</style>
