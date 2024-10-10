import React from 'react';
import './List-item.css';
const ListItem = ({ item }) => {
    return (
        <div className="list-item">
            <h3>{item.patient_last_name} {item.patient_first_name}</h3>
            <p>NUM SECU : {item.patient_social_security_number} | NUM MUT : {item.patient_mutuel}</p>
        </div>
    );
};

export default ListItem;