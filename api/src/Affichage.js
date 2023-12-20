import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Liste_Cartes = () => {
  const [listeCartes, setListeCartes] = useState([]);
  const [termeRecherche, setTermeRecherche] = useState('');
  const [typeFiltre, setTypeFiltre] = useState('nom');
  const [ordre_de_Tri, setOrdreTri] = useState('asc');

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get('http://localhost:3001/api/cartes');
        setListeCartes(response.data);
      } catch (erreur) {
        console.error('Erreur lors de la récupération de la liste de cartes Yu-Gi-Oh! :', erreur);
      }
    };

    fetchData();
  }, []);

  const cartes_Filtrees_Et_Trie = listeCartes
    .filter((carte) => carte.nom.toLowerCase().includes(termeRecherche.toLowerCase()))
    .sort((a, b) => {
      switch (typeFiltre) {
        case 'nom':
          return ordre_de_Tri === 'asc' ? a.nom.localeCompare(b.nom) : b.nom.localeCompare(a.nom);
        case 'prix':
          const prixA = a.Prix ? parseFloat(a.Prix) : 0;
          const prixB = b.Prix ? parseFloat(b.Prix) : 0;
          return ordre_de_Tri === 'asc' ? prixA - prixB : prixB - prixA;
        case 'rarete':
          const rareteA = a.rarete || ''; // Si rarete est nul, utilise une chaîne vide
          const rareteB = b.rarete || '';
          return ordre_de_Tri === 'asc' ? rareteA.localeCompare(rareteB) : rareteB.localeCompare(rareteA);
        case 'type':
          return ordre_de_Tri === 'asc' ? a.type.localeCompare(b.type) : b.type.localeCompare(a.type);
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
            <option value="type">Type</option>
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
            <img src={carte.image_carte} alt={carte.nom} />
            <div>
              <p>Nom : {carte.nom}</p>
              <p>Prix : {carte.Prix ? carte.Prix : [0]}</p>
              <p>Rareté : {carte.rarete}</p>
              <p>Type : {carte.type}</p>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Liste_Cartes;