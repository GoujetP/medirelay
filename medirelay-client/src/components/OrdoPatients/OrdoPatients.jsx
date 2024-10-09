import React from 'react';
import { useState } from 'react';
import ListOrdo from '../List-Patients/ListOrdo';
const OrdoPatients = ({idPatient}) => {
    const [prescriptions, setPrescriptions] = useState([
        { id: 12,date: '2023-10-01', doctorName: 'Olivier Dupont' , medicament: ['Doliprane','Ibuprofène','Strepsils'] },
        { id: 13,date: '2023-10-05', doctorName: 'Marc Martin' , medicament: ['Doliprane','Ibuprofène','Strepsils'] },
        { id: 14,date: '2023-10-10', doctorName: 'Jean-Charles Durand' , medicament: ['Doliprane','Ibuprofène','Strepsils'] }
    ]);
    return (
        <div>
            <h3>Bonjour, Monsieur/Madame</h3>
            <h1>Vos ordonnances</h1>
            <div className="scrollable-list">
                <ListOrdo list={prescriptions} idPatient={idPatient} />
            </div>
        </div>
    )
};

export default OrdoPatients;