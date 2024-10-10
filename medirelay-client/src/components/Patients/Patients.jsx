import React from 'react';
import ListPatients from '../List-Patients/ListPatients';
import './Patients.css';
import { useEffect, useState } from 'react';
const Patients = (doctorId) => {

    const [listPatient, setListPatient] = useState([]);

    useEffect(() => {
        const fetchPatients = () => {
            try {
                const token = document.cookie.split('; ').find(row => row.startsWith('jwtTokenDoctor=')).split('=')[1];
                if (!token) {
                    throw new Error('Token not found');
                }
                fetch(`http://localhost/medirelay-api/public/index.php/patients?role=Doctor&id=${parseInt(doctorId.doctorId)}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).then(response => response.json()).then(data => setListPatient(data));
            } catch (error) {
                console.error('Error fetching patients:', error);
            }
        };

        if (doctorId) {
            fetchPatients();
        } else {
            console.error('doctorId is not defined');
        }
    }, [doctorId]);
   

    return (
        <div>
            <h3>Bonjour, Docteur</h3>
            <h1>Vos patients</h1>
            <div className="scrollable-list">
                <ListPatients list={listPatient} />
            </div>
        </div>
    )
};

export default Patients;