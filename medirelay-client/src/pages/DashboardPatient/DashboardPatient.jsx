import React, { useState } from 'react';
import { useParams, useLocation } from 'react-router-dom';
import Menu from '../../components/Menu/Menu';
import { FaFilePrescription } from 'react-icons/fa';
import './DashboardPatient.css';
import OrdoPatients from '../../components/OrdoPatients/OrdoPatients';
import Modal from './Modal/Modal';
const DashboardPatient = () => {
    const { patientId } = useParams();
    const location = useLocation();
    const queryParams = new URLSearchParams(location.search);
    const patient = queryParams.get('patient');
    const confirmation = queryParams.get('confirmation') ? true : false;
    let patientBoolean = patient ? true : false;
    const [selectedComponent, setSelectedComponent] = useState('OrdoPatients');
    const [isModalOpen, setIsModalOpen] = useState(confirmation);

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
            return <OrdoPatients idPatient={patientId} />;
    };

    const closeModal = () => {
        setIsModalOpen(false);
    };


    return (
        <div className='container-dashboard'>
            <Menu tabMenu={tabMenu} onMenuItemClick={handleMenuItemClick} />
            <div className="dashboard-content">
            <Modal isOpen={isModalOpen} onClose={closeModal}>
                <h2>Votre commande a bien été passée</h2>
                <p>Vous allez recevoir un mail quand votre commande sera prête.</p>
            </Modal>
                {renderComponent()}
            </div>
        </div>
    );
};

export default DashboardPatient;