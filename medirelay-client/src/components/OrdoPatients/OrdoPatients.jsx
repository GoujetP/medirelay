import React from 'react';
import { useState, useEffect } from 'react';
import ListOrdo from '../List-Patients/ListOrdo';
const OrdoPatients = ({idPatient}) => {
    const [prescriptions, setPrescriptions] = useState([]);
    useEffect(() => {
        const fetchPatients = () => {
            try {
                const token = document.cookie.split('; ').find(row => row.startsWith('jwtTokenPatient=')).split('=')[1];
                if (!token) {
                    throw new Error('Token not found');
                }
                fetch(`http://192.168.137.2/medirelay-api/public/index.php/prescriptions?role=Patient&id=${idPatient}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).then(response => response.json()).then(data => setPrescriptions(data));
            } catch (error) {
                console.error('Error fetching patients:', error);
            }
        };

        if (idPatient) {
            fetchPatients();
        } else {
            console.error('idPatient is not defined');
        }
    }, [idPatient]); 
    console.log(prescriptions);
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