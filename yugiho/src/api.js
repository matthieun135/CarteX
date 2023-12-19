import React from 'react'
import axios from 'axios';
import connexion from './connexion.php';
import config from './config.php';

config();
connexion();
export default function api() {
    const addCardsToDatabase = async () => {
        try {
            const response = await axios.get('https://db.ygoprodeck.com/api/v7/cardinfo.php');
            const cards = response.data.data.slice(0, 300);

            cards.forEach(async (card) => {
                await axios.post('/api/cards', card);
            });

            console.log('Cartes ajoutées avec succès !');
        } catch (error) {
            console.error('Erreur lors de l\'ajout des cartes :', error);
        }
    };

    return (
        <div>
            <h1>Yugiho</h1>
            <button onClick={addCardsToDatabase}>Ajouter les cartes</button>
        </div>
    );
}
