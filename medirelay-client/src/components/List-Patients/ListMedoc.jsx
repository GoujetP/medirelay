import React from 'react';
import ListItem from './List-item-medoc/ListItemMedoc';

const ListMedoc = ({list}) => {
    return (
        <div>
            {list.map((item, index) => (
                <ListItem item={item} key={index} />
            ))}
        </div>
    );
};

export default ListMedoc;