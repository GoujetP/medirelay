import React from 'react';
import ListPatients from '../List-Patients/ListPatients';
import './Patients.css';
const Patients = (doctorId) => {
    const listPatient = [{
        nom: 'Dupont',
        prenom: 'Jean',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Durand',
        prenom: 'Pierre',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Martin',
        prenom: 'Paul',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Lefevre',
        prenom: 'Jacques',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Leroy',
        prenom: 'Michel',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },{
        nom: 'Dupont',
        prenom: 'Jean',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Durand',
        prenom: 'Pierre',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Martin',
        prenom: 'Paul',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Lefevre',
        prenom: 'Jacques',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Leroy',
        prenom: 'Michel',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },{
        nom: 'Dupont',
        prenom: 'Jean',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Durand',
        prenom: 'Pierre',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Martin',
        prenom: 'Paul',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Lefevre',
        prenom: 'Jacques',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    },
    {
        nom: 'Leroy',
        prenom: 'Michel',
        numSecu: '123456789123456',
        numMut: '123456789123456'
    }]
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