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
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { fetchData } from '../composables/useData.js';
import { postData } from '../composables/useData.js';
import { listAllFiles } from '../composables/useData.js';

const { data, fileName, loadData } = fetchData('luca.json');
const { fileList, loadAllFiles } = listAllFiles();
const { updateData } = postData();

onMounted(async () => {
    await loadData();
    await loadAllFiles();
});

</script>

<style lang="scss" >
/* Add some styles if needed */
</style>
