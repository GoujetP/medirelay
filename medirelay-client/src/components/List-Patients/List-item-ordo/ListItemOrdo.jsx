import React from 'react';
import '../List-item/List-item.css';
import { Link } from 'react-router-dom';
const ListItem = ({ item,idPatient }) => {
    return (
        <Link to={`/ordo-detail/${idPatient}/${item.prescription_id}`} style={{textDecoration: "none" , color: "black"}}>
            <div className="list-item">
                <h3>Ordonnance du {new Date(item.prescription_renewal_date).toLocaleDateString('FR-fr')}</h3>
                <p>Durée du traitement {item.prescription_traitment_duration} jours</p>
            </div>
        </Link>
    );
};

export default ListItem;