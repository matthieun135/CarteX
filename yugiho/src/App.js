import './App.css';
import React from 'react';
import api from './api.js';

function App() {
  return (
    <div className="App">
      <h1>Yugiho</h1>
      <button onClick={api.addCardsToDatabase}>Ajouter les cartes</button>
    </div>
  );
}

export default App;
