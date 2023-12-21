const express = require('express');
const mysql = require('mysql');
const cors = require('cors');
const dotenv = require('dotenv');

dotenv.config();

const app = express();
const port = 3001;

app.use(cors());

const connection = mysql.createConnection({
  host: "localhost",
  user: "radu",
  password: "radu",
  database: "cartex"
});

app.get('/api/cartes', (req, res) => {
  const query = 'SELECT * FROM carte';
  connection.query(query, (error, results) => {
    if (error) {
      console.error('Erreur lors de la récupération des données depuis la base de données :', error);
      res.status(500).send('Erreur serveur');
    } else {
      res.json(results);
    }
  });
});

app.listen(port, () => {
  console.log(`Serveur écoutant sur le port ${port}`);
});
