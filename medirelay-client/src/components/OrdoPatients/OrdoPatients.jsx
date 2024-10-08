import React from 'react';
import { useState } from 'react';
import ListOrdo from '../List-Patients/ListOrdo';
const OrdoPatients = () => {
    const [prescriptions, setPrescriptions] = useState([
        { date: '2023-10-01', doctorName: 'Dr. Dupont' },
        { date: '2023-10-05', doctorName: 'Dr. Martin' },
        { date: '2023-10-10', doctorName: 'Dr. Durand' }
    ]);
    return (
        <div>
            <h3>Bonjour, Monsieur/Madame</h3>
            <h1>Vos ordonnances</h1>
            <div className="scrollable-list">
                <ListOrdo list={prescriptions} />
            </div>
        </div>
    )
};

export default OrdoPatients;