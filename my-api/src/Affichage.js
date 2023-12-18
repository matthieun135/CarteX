import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Liste_Cartes = () => {
  const [listeCartes, setListeCartes] = useState([]);
  const [termeRecherche, setTermeRecherche] = useState('');
  const [typeFiltre, setTypeFiltre] = useState('nom'); // tri par nom
  const [ordre_de_Tri, setOrdreTri] = useState('asc'); // tri par odre croissant

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get('https://db.ygoprodeck.com/api/v7/cardinfo.php');
        const cartes = response.data.data.slice(0, 300); // j'ai limiter à seulement les 300 premières cartes car sinon ca lague
        setListeCartes(cartes);
      } catch (erreur) {
        console.error('Erreur lors de la récupération de la liste de cartes Yu-Gi-Oh! :', erreur);
      }
    };

    fetchData();
  }, []);

  // 
  const cartes_Filtrees_Et_Trie = listeCartes
    .filter((carte) => carte.name.toLowerCase().includes(termeRecherche.toLowerCase()))
    .sort((a, b) => {
      switch (typeFiltre) {
        case 'nom':
          return ordre_de_Tri === 'asc' ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name);
        case 'prix':
          const prixA = a.card_prices ? parseFloat(a.card_prices[0].cardmarket_price) : 0;
          const prixB = b.card_prices ? parseFloat(b.card_prices[0].cardmarket_price) : 0;
          return ordre_de_Tri === 'asc' ? prixA - prixB : prixB - prixA;
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
          </select>
        </label>
        <label>
          Ordre :
          <select value={ordre_de_Tri} onChange={(e) => setOrdreTri(e.target.value)}>
            <option value="asc">Croissant</option>
            <option value="desc">Décroissant</option>
          </select>
        </label>
      </div>

      <ul>
        {cartes_Filtrees_Et_Trie.map((carte) => (
          <li key={carte.id}>
            <img src={carte.card_images[0].image_url} alt={carte.name} />
            <div>
              <p>Nom : {carte.name}</p>
              <p>Prix : {carte.card_prices ? carte.card_prices[0].cardmarket_price : 'N/A'}</p>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Liste_Cartes;
