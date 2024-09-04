const express = require('express');
const fs = require('fs');
const path = require('path');
const cors = require('cors');

const app = express();
const port = 3000;

app.use(cors({ origin: 'http://localhost:5173' }));
app.use(express.json()); // For parsing application/json

// Serve JSON data
app.get('/api/data', (req, res) => {
  const filePath = path.join(__dirname, 'data', 'data.json');
  fs.readFile(filePath, 'utf8', (err, data) => {
    if (err) {
      return res.status(500).json({ error: 'Error reading data file' });
    }
    res.json(JSON.parse(data));
  });
});

// Update JSON data
app.post('/api/data', (req, res) => {
  const { fileName, ...newData } = req.body;
  const filePath = path.join(__dirname, 'data', fileName || 'data.json');
  
  fs.writeFile(filePath, JSON.stringify(newData, null, 2), (err) => {
    if (err) {
      return res.status(500).json({ error: 'Error writing data file' });
    }
    res.json({ message: 'Data updated successfully' });
  });
});

app.listen(port, () => {
  console.log(`Server running on http://localhost:${port}`);
});
