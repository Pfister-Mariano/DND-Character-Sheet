// src/composables/useData.js

import { ref } from "vue";
import axios from "axios";

// Define reactive state
const data = ref({
    name: "",
    email: "",
    note: "",
});

const fileName = ref("data.json");

const fileList = ref([]);

export function listAllFiles() {
    const loadAllFiles = async () => {
        try {
            const response = await axios.get("http://localhost:3000/api/files");
            fileList.value = response.data;
            
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    };

    return {
        fileList,
        loadAllFiles,
    };
}

export function fetchData() {
    const loadData = async (filename) => {
        try {
            const response = await axios.get(`http://localhost:3000/api/data/${filename}`);

            data.value = typeof response.data === "string" ? JSON.parse(response.data) : response.data;
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    };

    return {
        data,
        fileName,
        loadData,
    };
}

export function postData() {
    const saveData = async (filename) => {
        fileName.value = filename;
        try {
            await axios.post("http://localhost:3000/api/data", {
                ...data.value,
                fileName: filename,
            });
            // alert(`Data updated successfully! ${filename}`);
        } catch (error) {
            console.error("Error updating data:", error);
        }
    };

    return {
        data,
        fileName,
        saveData,
    };
}
