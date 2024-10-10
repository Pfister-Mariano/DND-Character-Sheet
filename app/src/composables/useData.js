// src/composables/useData.js
import { ref } from "vue";
import axios from "axios";

// Set base URL for axios
axios.defaults.baseURL = "/"; // Ensure this matches your server

// Define reactive state
const data = ref({
    name: "",
    email: "",
    note: "",
});

const fileName = ref("data.json");
const fileList = ref([]);

// List all files from the backend
export function listAllFiles() {
    const loadAllFiles = async () => {
        try {
            const response = await axios.get("/", {
                params: {
                    action: 'listFiles' // Specify action in query
                }
            });
            fileList.value = response.data; // Should receive an array of filenames
        } catch (error) {
            console.error("Error fetching files:", error);
            alert("Could not load files. Please try again."); // User feedback
        }
    };

    return {
        fileList,
        loadAllFiles,
    };
}

// Fetch data from a specific file
export function fetchData() {
    const loadData = async (filename) => {
        try {
            const response = await axios.get("/", {
                params: {
                    action: 'getData', // Specify action in query
                    filename: filename // Send the filename as a parameter
                }
            });
            data.value = response.data; // Axios already handles JSON parsing
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

// Post data to the backend
export function postData() {
    const saveData = async (filename) => {
        fileName.value = filename; // Set filename for reference
        try {
            const response = await axios.post("/", {
                action: 'saveData', // Specify action in query
                ...data.value,
                fileName: filename, // Make sure filename is sent correctly
            });
            console.log(response.data); // Log response for debugging
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
