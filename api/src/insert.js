const axios = require("axios");
const mysql = require("mysql");

const connection = mysql.createConnection({
  host: "localhost",
  user: "radu",
  password: "radu",
  database: "cartex"
});

connection.connect();

const apiUrl = 'https://db.ygoprodeck.com/api/v7/cardinfo.php';

const InsertInTable = async () => {
  try {
    const response = await axios.get(apiUrl);
    const cards = response.data.data.slice(0, 500);

    cards.forEach(async (card) => {
      const { name, type, desc, level ,card_images, card_prices, card_sets } = card;
      const image_carte = card_images[0].image_url;
      const prix = card_prices[0] ? card_prices[0].cardmarket_price : null;
      const rarete = card_sets && card_sets[0] ? card_sets[0].set_rarity : null;

      const query = "INSERT INTO carte (nom, type, image_carte, description, niveau, Prix, rarete ) VALUES (?,?,?, ?, ?,?,?)";
      connection.query(query, [name, type , image_carte ,desc, level,prix, rarete ], (error, results) => {
        if (error) {
          console.error("Erreur lors de l'insertion des données :", error);
        } else {
          console.log('Données insérées avec succès !');
        }
      });
    });
  } catch (error) {
    console.error("Erreur lors de la récupération des données depuis l'API :", error);
  } finally {
    connection.end();
  }
};

InsertInTable();



