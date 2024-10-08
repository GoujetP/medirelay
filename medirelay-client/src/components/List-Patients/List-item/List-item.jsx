import React from 'react';
import './List-item.css';
const ListItem = ({ item }) => {
    return (
        <div className="list-item">
            <h3>{item.nom} {item.prenom}</h3>
            <p>NUM SECU : {item.numSecu} | NUM MUT : {item.numMut}</p>
        </div>
    );
};

export default ListItem;