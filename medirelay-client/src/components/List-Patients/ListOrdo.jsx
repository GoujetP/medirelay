import React from 'react';
import ListItem from './List-item-ordo/ListItemOrdo';

const ListOrdo = ({list}) => {
    return (
        <div>
            {list.map((item, index) => (
                <ListItem item={item} key={index} />
            ))}
        </div>
    );
};

export default ListOrdo;