import React from 'react';
import '../List-item/List-item.css';
const ListItem = ({ item }) => {
    return (
        <div className="list-item">
            <h3>Docteur {item.doctorName}</h3>
            <p>Ordonnance du {item.date}</p>
        </div>
    );
};

export default ListItem;