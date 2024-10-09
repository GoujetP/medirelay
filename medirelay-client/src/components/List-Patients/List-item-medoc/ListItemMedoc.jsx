import React from 'react';
import '../List-item/List-item.css'; 
const ListItem = ({ item }) => {
    return (
            <div className="list-item-medoc">
                <h3>{item.name} </h3>
                <p>Date de péremption : {item.expirationDate}</p>
            </div>
    );
};

export default ListItem;