import React, { useState } from 'react';
import Select from 'react-select';
import ordonnance from '../../assets/img/ordonnance-template.png';
import './CreatePresciption.css';
const CreatePrescription = () => {
    const listPatient = [
        { nom: 'Dupont', prenom: 'Jean', numSecu: '123456789123456', numMut: '123456789123456' },
        { nom: 'Durand', prenom: 'Pierre', numSecu: '123456789123456', numMut: '123456789123456' },
        { nom: 'Martin', prenom: 'Paul', numSecu: '123456789123456', numMut: '123456789123456' },
        { nom: 'Lefevre', prenom: 'Jacques', numSecu: '123456789123456', numMut: '123456789123456' },
        { nom: 'Leroy', prenom: 'Michel', numSecu: '123456789123456', numMut: '123456789123456' }
    ];

    const listMedicaments = [
        { value: 'paracetamol', label: 'Paracetamol' },
        { value: 'ibuprofen', label: 'Ibuprofen' },
        { value: 'aspirin', label: 'Aspirin' },
        { value: 'amoxicillin', label: 'Amoxicillin' },
        { value: 'ciprofloxacin', label: 'Ciprofloxacin' },
        { value: 'metformin', label: 'Metformin' },
        { value: 'atorvastatin', label: 'Atorvastatin' },
        { value: 'omeprazole', label: 'Omeprazole' },
        { value: 'lisinopril', label: 'Lisinopril' },
        { value: 'simvastatin', label: 'Simvastatin' }
      ];

    const [selectedMedicaments, setSelectedMedicaments] = useState([]);
    const [selectedPatient, setSelectedPatient] = useState('');

    const handleMedicamentsChange = (selectedOptions) => {
        setSelectedMedicaments(selectedOptions);
    };

    const handlePatientChange = (e) => {
        setSelectedPatient(e.target.value);
        console.log(selectedPatient);
    };
    return (
        <div className='container-ordo'>
            <h3>Bonjour, Docteur</h3>
            <h1>Créer ou renouveler une ordonnance</h1>
            <div className='container-form-ordo'>
                <form >
                    <div className='select-ordo'>
                        <label htmlFor="patient">Patient:</label>
                        <select id="patient" name="patient" onChange={handlePatientChange}>
                            {listPatient.map((patient, index) => (
                                <option key={index} value={patient.numSecu}>
                                    {patient.nom} {patient.prenom}
                                </option>
                            ))}
                        </select>
                    </div>
                    <div className='select-ordo'>
                        <label htmlFor="medicaments">Médicaments:</label>
                        <Select options={listMedicaments} isMulti name="medicament" onChange={handleMedicamentsChange} />
                    </div>
                    <button type="submit" className='button-form-login'>Créer l'ordonnance</button>
                </form>
                <div className='image-container'>
                    <img src={ordonnance} alt="" className='ordonnance-image' />
                    {selectedPatient && (
                        <div className='text-overlay'>
                            <p>Numéro de Sécurité Sociale: {selectedPatient}</p>
                        </div>
                    )}
                    {selectedMedicaments.length > 0 && (
                        <div className='text-overlay-2'>
                            <p>Médicaments:</p>
                            <ul>
                                {selectedMedicaments.map((medicament, index) => (
                                    <li key={index}>{medicament.label}</li>
                                ))}
                            </ul>
                        </div>
                    )}
                </div>
            </div>

        </div>
    );
};

export default CreatePrescription;