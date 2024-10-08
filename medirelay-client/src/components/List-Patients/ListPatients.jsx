import React from 'react';
import ListItem from './List-item/List-item';

const ListPatients = ({list}) => {
    return (
        <div>
            {list.map((item, index) => (
                <ListItem item={item} key={index} />
            ))}
        </div>
    );
};

export default ListPatients;