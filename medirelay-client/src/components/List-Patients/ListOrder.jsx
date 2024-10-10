import React from 'react';
import ListItem from './List-item-order/ListItemOrder';

const ListOrder = ({list}) => {
    return (
        <div>
            {list.map((item, index) => (
                <ListItem item={item} key={index} />
            ))}
        </div>
    );
};

export default ListOrder;