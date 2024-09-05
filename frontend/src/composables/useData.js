// src/composables/useData.js

import { ref } from 'vue';
import axios from 'axios';

// Define reactive state
const data = ref({
  name: '',
  email: '',
  note: ''
});

const fileName = ref('data.json');

// Fetch data function
export function fetchData() {
  const loadData = async () => {
    try {
      const response = await axios.get('http://localhost:3000/api/data');
      data.value = response.data;
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  return {
    data,
    fileName,
    loadData
  };
}

// Update data function
export function postData() {
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

  return {
    data,
    fileName,
    updateData
  };
}
