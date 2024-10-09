import React from 'react';
import '../List-item/List-item.css'; 
const ListItem = ({ patient,docteur,ordo }) => {
    return (
            <div className="list-item">
                <h3>{patient.nom} {patient.prenom}  </h3>
                <p>Ordonnance NUM : {ordo.id} de la part du docteur {docteur.name}</p>
            </div>
    );
};

export default ListItem;