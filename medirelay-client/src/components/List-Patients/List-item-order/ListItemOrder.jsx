import React from 'react';
import '../List-item/List-item.css'; 
const ListItem = ({ item }) => {
    return (
            <div className="list-item">
                <h3>{item.patient_last_name} {item.patient_first_name}  </h3>
                <p>Ordonnance NUM : {item.prescription} de la part du docteur {item.doctor_last_name} {item.doctor_first_name}</p>
            </div>
    );
};

export default ListItem;