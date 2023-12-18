import React, { useState, useEffect } from 'react';
import axios from 'axios';

const YuGiOhCardList = () => {
  const [cardList, setCardList] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get('https://db.ygoprodeck.com/api/v7/cardinfo.php');
        setCardList(response.data.data);
      } catch (error) {
        console.error('Erreur lors de la récupération de la liste de cartes Yu-Gi-Oh! :', error);
      }
    };

    fetchData();
  }, []);


  return (
    <div>
      <h1>Yu-Gi-Oh! Card Liste</h1>
      <ul>
        {cardList.map((card, index) => (
          <li key={index}>
            {card.name}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default YuGiOhCardList;
