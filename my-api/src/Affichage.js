import React, { useState, useEffect } from 'react';
import axios from 'axios';

const ListeCartesYuGiOh = () => {
  const [listeCartes, setListeCartes] = useState([]);
  const [termeRecherche, setTermeRecherche] = useState('');
  const [typeFiltre, setTypeFiltre] = useState('nom'); // Par défaut, tri par nom
  const [ordreTri, setOrdreTri] = useState('asc'); // Par défaut, tri croissant

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get('https://db.ygoprodeck.com/api/v7/cardinfo.php');
        const cartes = response.data.data.slice(0, 300); // Limiter à seulement les 300 premières cartes
        setListeCartes(cartes);
      } catch (erreur) {
        console.error('Erreur lors de la récupération de la liste de cartes Yu-Gi-Oh! :', erreur);
      }
    };

    fetchData();
  }, []);

  // Filtrer et trier les cartes en fonction des termes et des options de tri
  const cartesFiltreesEtTrie = listeCartes
    .filter((carte) => carte.name.toLowerCase().includes(termeRecherche.toLowerCase()))
    .sort((a, b) => {
      switch (typeFiltre) {
        case 'nom':
          return ordreTri === 'asc' ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name);
        case 'prix':
          const prixA = a.card_prices ? parseFloat(a.card_prices[0].cardmarket_price) : 0;
          const prixB = b.card_prices ? parseFloat(b.card_prices[0].cardmarket_price) : 0;
          return ordreTri === 'asc' ? prixA - prixB : prixB - prixA;
        case 'rarete':
          const rareteA = a.card_prices ? a.card_prices[0].rarity : 'N/A';
          const rareteB = b.card_prices ? b.card_prices[0].rarity : 'N/A';
          return ordreTri === 'asc' ? rareteA.localeCompare(rareteB) : rareteB.localeCompare(rareteA);
        default:
          return 0;
      }
    });

  return (
    <div>
      <h1>Liste de Cartes Yu-Gi-Oh!</h1>

      {/* Barre de recherche */}
      <input
        type="text"
        placeholder="Rechercher par nom"
        value={termeRecherche}
        onChange={(e) => setTermeRecherche(e.target.value)}
      />

      {/* Options de tri */}
      <div>
        <label>
          Trier par :
          <select value={typeFiltre} onChange={(e) => setTypeFiltre(e.target.value)}>
            <option value="nom">Nom</option>
            <option value="prix">Prix</option>
            <option value="rarete">Rareté</option>
          </select>
        </label>
        <label>
          Ordre :
          <select value={ordreTri} onChange={(e) => setOrdreTri(e.target.value)}>
            <option value="asc">Croissant</option>
            <option value="desc">Décroissant</option>
          </select>
        </label>
      </div>

      <ul>
        {cartesFiltreesEtTrie.map((carte) => (
          <li key={carte.id}>
            <img src={carte.card_images[0].image_url} alt={carte.name} />
            <div>
              <p>ID : {carte.id}</p>
              <p>Nom : {carte.name}</p>
              <p>Prix : {carte.card_prices ? carte.card_prices[0].cardmarket_price : 'N/A'}</p>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
};
  

export default ListeCartesYuGiOh;

