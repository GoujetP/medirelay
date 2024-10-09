import React from 'react';
import ListItem from './List-item-ordo/ListItemOrdo';

const ListOrdo = ({list,idPatient}) => {
    return (
        <div>
            {list.map((item, index) => (
                <ListItem item={item} idPatient={idPatient} key={index} />
            ))}
        </div>
    );
};

export default ListOrdo;