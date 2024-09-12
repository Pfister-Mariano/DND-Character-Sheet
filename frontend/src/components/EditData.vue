<template>
    <div>
        <h1>Edit Data</h1>
        <form @submit.prevent="updateData">
            <label for="name">Name:</label>
            <input v-model="data.name" id="name" type="text" />
            <br><br>

            <label for="email">Email:</label>
            <input v-model="data.email" id="email" type="email" />
            <br><br>

            <label for="note">Note:</label>
            <input v-model="data.note" id="note" type="text" />
            <br><br>

            <label for="fileName">File Name:</label>
            <input v-model="fileName" id="fileName" type="text" />
            <br><br>

            <button type="submit">Save</button>
        </form>
        <br><br><br><br>
        <pre>{{ data }}</pre>
        <br><br><br><br>
        <pre>{{ fileList }}</pre>
        <br><br><br><br>
        <section style="height: 500px;width: 500px;background-color: gray;" id="editorjs"></section>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { fetchData } from '../composables/useData.js';
import { postData } from '../composables/useData.js';
import { listAllFiles } from '../composables/useData.js';

import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header'; 
import List from '@editorjs/list'; 

const { data, fileName, loadData } = fetchData('luca.json');
const { fileList, loadAllFiles } = listAllFiles();
const { updateData } = postData();

onMounted(async () => {
    await loadData();
    await loadAllFiles();
});

const editor = new EditorJS({
    /**
     * Id of Element that should contain the Editor
     */
    holderId: 'editorjs',

    /**
     * Previously saved data that should be rendered
     */
    tools: {
        header: Header,
        list: List
    },
});

</script>

<style lang="scss">
/* Add some styles if needed */
</style>
