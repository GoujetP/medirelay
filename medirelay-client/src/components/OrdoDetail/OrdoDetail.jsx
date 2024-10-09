import React from 'react';
import { useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { FaFilePrescription } from 'react-icons/fa';
import Menu from '../Menu/Menu';
import ListMedoc from '../List-Patients/ListMedoc';
import Select from 'react-select';
import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet';
import 'leaflet/dist/leaflet.css';
import "./OrdoDetail.css";
const OrdoDetail = () => {
    const { idPatient, idOrdo } = useParams();
    const navigate = useNavigate();
    const [selectedComponent, setSelectedComponent] = useState('Patients');
    const pharmacies = [
        { id: 1, name: 'Pharmacie Centrale', address: '123 Rue de la Santé', position: [48.8566, 2.3522] },
        { id: 2, name: 'Pharmacie du Parc', address: '456 Avenue des Fleurs', position: [48.8584, 2.2945] },
        { id: 3, name: 'Pharmacie de la Gare', address: '789 Boulevard des Trains', position: [48.8606, 2.3376] }
    ];
    const prescriptions = [
        {
            id: 12,
            date: '2023-10-01',
            doctorName: 'Olivier Dupont',
            medicament: [
                { name: 'Doliprane', expirationDate: '2024-05-01' },
                { name: 'Ibuprofène', expirationDate: '2024-06-15' },
                { name: 'Strepsils', expirationDate: '2024-07-20' }
            ]
        },
        {
            id: 13,
            date: '2023-10-05',
            doctorName: 'Marc Martin',
            medicament: [
                { name: 'Doliprane', expirationDate: '2024-05-01' },
                { name: 'Ibuprofène', expirationDate: '2024-06-15' },
                { name: 'Strepsils', expirationDate: '2024-07-20' }
            ]
        },
        {
            id: 14,
            date: '2023-10-10',
            doctorName: 'Jean-Charles Durand',
            medicament: [
                { name: 'Doliprane', expirationDate: '2024-05-01' },
                { name: 'Ibuprofène', expirationDate: '2024-06-15' },
                { name: 'Strepsils', expirationDate: '2024-07-20' }
            ]
        }
    ];
    const prescription = prescriptions.find(p => p.id === parseInt(idOrdo));
    const [selectedPharmacy, setSelectedPharmacy] = useState(null);

    const handleSelectChange = (selectedOption) => {
        setSelectedPharmacy(selectedOption);
    };

    const options = pharmacies.map(pharmacy => ({
        value: pharmacy.id,
        label: `${pharmacy.name} - ${pharmacy.address}`
    }));
    if (!prescription) {
        return <div>Ordonnance non trouvée</div>;
    }

    const tabMenu = [
        {
            icon: <FaFilePrescription />,
            libelle: 'Vos ordonnances',
            component: 'OrdoPatients'
        }
    ];

    const handleMenuItemClick = (component) => {
        setSelectedComponent(component);
    };

    const renderComponent = () => {
        switch (selectedComponent) {
            case 'OrdoPatients':
                return <OrdoPatients doctorId={doctorId} />;
            default:
                return null;
        }
    };

    const handleBackClick = () => {
        navigate(-1); // Navigate to the previous page
    };

    return (
        <div className='container-dashboard'>
            <Menu tabMenu={tabMenu} onMenuItemClick={handleMenuItemClick} />
            <div className="dashboard-content ordo-border">
                <h1>Détails de l'ordonnance du {new Date(prescription.date).toLocaleDateString('fr-FR')}</h1>
                <h3>Médecin: {prescription.doctorName}</h3>
                <ListMedoc list={prescription.medicament} />
                <button onClick={handleBackClick} className='button-form-login'>Retour</button>
            </div>
            <div className='container-map'>
                <Select
                    options={options}
                    onChange={handleSelectChange}
                    placeholder="Sélectionnez une pharmacie"
                />
                <MapContainer center={[48.8566, 2.3522]} zoom={13} style={{ height: '35em', width : '100%',marginTop: '20px', zIndex: '0' }}>
                    <TileLayer
                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                        attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    />
                    {selectedPharmacy && (
                        <Marker position={pharmacies.find(pharmacy => pharmacy.id === selectedPharmacy.value).position}>
                            <Popup>
                                {selectedPharmacy.label}
                            </Popup>
                        </Marker>
                    )}
                </MapContainer>
                <button className='button-form-login' onClick={()=>{navigate("/dashboard-patient/" + idPatient + "?confirmation=true")}} >Commander vos médicaments</button>
                <button className='button-form-login' onClick={()=>{navigate("/dashboard-patient/" + idPatient + "?confirmation=true")}}>Renouveler votre ordonnance</button>
            </div>
        </div>
    );
};

export default OrdoDetail;