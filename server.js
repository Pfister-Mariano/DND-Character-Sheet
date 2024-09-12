const express = require('express');
const fs = require('fs').promises; // Using promises for async/await
const path = require('path');
const cors = require('cors');

const app = express();
const port = 3000;

app.use(cors({ origin: 'http://localhost:5173' }));
app.use(express.json());

// Serve JSON data
app.get('/api/data/:filename', async (req, res) => {
    const { filename } = req.params;
    const filePath = path.join(__dirname, 'data', filename);

    try {
        const data = await fs.readFile(filePath, 'utf8');
        res.json(JSON.parse(data));
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: 'Error reading data file' });
    }
});

// Additional route to list all files in the /data folder
app.get('/api/files', async (req, res) => {
    const dirPath = path.join(__dirname, 'data');

    try {
        const files = await fs.readdir(dirPath);
        res.json(files);
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: 'Error reading directory' });
    }
});

// Update JSON data
app.post('/api/data', async (req, res) => {
    const { fileName, ...newData } = req.body; // fileName (capital N) is expected here
    const filePath = path.join(__dirname, 'data', fileName || 'data.json'); // Uses fileName here

    try {
        await fs.writeFile(filePath, JSON.stringify(newData, null, 2));
        res.json({ message: 'Data updated successfully' });
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: 'Error writing data file' });
    }
});

app.listen(port, () => {
    console.log(`Server running on http://localhost:${port}`);
});
