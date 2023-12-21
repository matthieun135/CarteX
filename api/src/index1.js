const express = require('express');
const mysql = require('mysql');
const app = express();
const port = 3000; 

// Configuration de la base de données
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'CarteX'
});

// Connexion à la base de données
connection.connect();

// Point de terminaison GET pour récupérer toutes les cartes
app.get('/api/carte', (req, res) => {
  const query = 'SELECT * FROM carte';

  // Exécution de la requête SQL
  connection.query(query, (error, results) => {
    if (error) {
      console.error('Erreur lors de la récupération des cartes :', error);
      res.status(500).json({ error: 'Erreur serveur' });
    } else {
      res.json(results);
    }
  });
});

// Écoute du port
app.listen(port, () => {
  console.log("Serveur démarré sur le port");
});