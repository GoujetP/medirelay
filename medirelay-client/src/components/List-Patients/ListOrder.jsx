import React from 'react';
import ListItem from './List-item-order/ListItemOrder';

const ListOrder = ({list}) => {
    return (
        <div>
            {list.map((item, index) => (
                <ListItem patient={item.patient} docteur={item.docteur} ordo={item.ordo} key={index} />
            ))}
        </div>
    );
};

export default ListOrder;