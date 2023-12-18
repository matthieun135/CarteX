import React, { useEffect, useState } from 'react';

function MyComponent() {
  const [cardData, setCardData] = useState([]);

  useEffect(() => {
    const fetchCardData = async () => {
      try {
        const response = await fetch('https://db.ygoprodeck.com/api/v7/cardinfo.php');
        if (response.ok) {
          const data = await response.json();
          const cards = data.data;

            // Extraire les informations pertinentes des données de la carte
          const formattedCards = cards.map((card, index) => {
            return {
              id: index,
              nom: card.nom,
              imageUrl: card.card_images[0].image_url,
              type: card.type,
              descriptions: carte.descriptions,
              prix: card.prix,
              rarete: card.rarete,
            };
          });

          setCardData(formattedCards);
        } else {
          console.error('Échec de la récupération des données de la carte');
        }
      } catch (error) {
        console.error('Erreur lors de la requête API :', error);
      }
    };

    fetchCardData();
  }, []);

  return (
    <div>
      <div style={gridContainerStyle}>
        {cardData.map((card) => (
          <div key={card.id} style={cardStyle}>
            <h2>Nom : {card.nom}</h2>
            <img src={card.imageUrl} alt={card.name} />
            <p>Type : {card.type}</p>
            <p>Descriptions : {card.descriptions}</p>
            <p>prix : {card.prix}</p>
            <p>rarete : {card.rarete}</p>
            <button onClick={handleAddToCart}>Ajouter</button>
          </div>
        ))}
      </div>
    </div>
  );
}

export default MyComponent;
