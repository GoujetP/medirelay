import React from 'react';
import { useState , useEffect} from 'react';
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
    const [pharmacies, setPharmacies] = useState([]);
    const [prescriptions, setPrescriptions] = useState([]);
    useEffect(() => {
        const fetchPatients = () => {
            try {
                const token = document.cookie.split('; ').find(row => row.startsWith('jwtTokenPatient=')).split('=')[1];
                if (!token) {
                    throw new Error('Token not found');
                }
                fetch(`http://192.168.137.2/medirelay-api/public/index.php/medicines?role=All&id=${idOrdo}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).then(response => response.json()).then(data => setPrescriptions(data));
                console.log(prescriptions);
            } catch (error) {
                console.error('Error fetching patients:', error);
            }
        };
        const fetchPharmas = () => {
            try {
                const token = document.cookie.split('; ').find(row => row.startsWith('jwtTokenPatient=')).split('=')[1];
                if (!token) {
                    throw new Error('Token not found');
                }
                fetch(`http://192.168.137.2/medirelay-api/public/index.php/pharmacy`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).then(response => response.json()).then(data => setPharmacies(data));
                console.log(prescriptions);
            } catch (error) {
                console.error('Error fetching patients:', error);
            }
        };

        if (idOrdo) {
            fetchPatients();
            fetchPharmas();
        } else {
            console.error('idOrdo is not defined');
        }
    }, [idPatient]); 
    
    const [selectedPharmacy, setSelectedPharmacy] = useState(null);

    const handleSelectChange = (selectedOption) => {
        setSelectedPharmacy(selectedOption);
    };

    const options = pharmacies.map(pharmacy => ({
        value: pharmacy.pharmacy_id,
        label: `${pharmacy.pharmacy_name} - ${pharmacy.pharmacy_address}`
    }));
    if (!prescriptions) {
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
    console.log(pharmacies);
    return (
        <div className='container-dashboard'>
            <Menu tabMenu={tabMenu} onMenuItemClick={handleMenuItemClick} />
            <div className="dashboard-content ordo-border">
                <h1>Détails de l'ordonnance du {new Date(prescriptions.date).toLocaleDateString('fr-FR')}</h1>
                <ListMedoc list={prescriptions} />
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
                        <Marker position={[48.8566, 2.3522]}>
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