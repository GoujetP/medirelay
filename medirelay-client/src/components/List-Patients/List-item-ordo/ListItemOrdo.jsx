import React from 'react';
import '../List-item/List-item.css';
import { Link } from 'react-router-dom';
const ListItem = ({ item,idPatient }) => {
    return (
        <Link to={`/ordo-detail/${idPatient}/${item.id}`} style={{textDecoration: "none" , color: "black"}}>
            <div className="list-item">
                <h3>Docteur {item.doctorName}</h3>
                <p>Ordonnance du {item.date}</p>
            </div>
        </Link>
    );
};

export default ListItem;