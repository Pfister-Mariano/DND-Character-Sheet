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
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Define reactive state
const data = ref({
  name: '',
  email: '',
  note: ''
});
const fileName = ref('data.json');

// Fetch data when the component is mounted
const fetchData = async () => {
  try {
    const response = await axios.get('http://localhost:3000/api/data');
    data.value = response.data;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
};

// Update data by sending it to the API
const updateData = async () => {
  try {
    await axios.post('http://localhost:3000/api/data', {
      ...data.value,
      fileName: fileName.value
    });
    alert('Data updated successfully!');
  } catch (error) {
    console.error('Error updating data:', error);
  }
};

// Call fetchData on component mount
onMounted(fetchData);
</script>

<style>
/* Add some styles if needed */
</style>
