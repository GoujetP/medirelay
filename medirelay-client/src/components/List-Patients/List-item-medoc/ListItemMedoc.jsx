import React from 'react';
import '../List-item/List-item.css'; 
const ListItem = ({ item }) => {
    return (
            <div className="list-item-medoc">
                <h3>{item.medicine_name} </h3>
                <p>Date de péremption : {new Date(item.medicine_expiry_date).toLocaleDateString('FR-fr')}</p>
            </div>
    );
};

export default ListItem;