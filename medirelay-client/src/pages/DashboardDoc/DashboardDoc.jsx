import React, { useState } from 'react';
import { useParams , useLocation} from 'react-router-dom';
import Menu from '../../components/Menu/Menu';
import { FaUserMd, FaPrescriptionBottleAlt } from 'react-icons/fa';
import './Dashboard.css';
import Patients from '../../components/Patients/Patients';
import CreatePrescription from '../../components/CreatePrescription/CreatePrescription';
import Modal from './Modal/Modal';

const DashboardDoc = () => {
    const { doctorId } = useParams();
    const location = useLocation();
    const queryParams = new URLSearchParams(location.search);
    const patient = queryParams.get('patient');
    console.log(doctorId, patient);
    let patientBoolean= patient ? true : false;
    const [selectedComponent, setSelectedComponent] = useState('Patients');
    const [isModalOpen, setIsModalOpen] = useState(patientBoolean);

    const tabMenu = [
        {
            icon: <FaUserMd />,
            libelle: 'Vos patients',
            component: 'Patients'
        },
        {
            icon: <FaPrescriptionBottleAlt />,
            libelle: 'Créer une ordonnance',
            component: 'CreatePrescription'
        }
    ];

    const handleMenuItemClick = (component) => {
        setSelectedComponent(component);
    };

    const renderComponent = () => {
        switch (selectedComponent) {
            case 'Patients':
                return <Patients doctorId={doctorId} />;
            case 'CreatePrescription':
                return <CreatePrescription />;
            default:
                return null;
        }
    };

    const closeModal = () => {
        setIsModalOpen(false);
    };

    return (
        <div className='container-dashboard'>
            <Menu tabMenu={tabMenu} onMenuItemClick={handleMenuItemClick} />
            <div className="dashboard-content">
            <Modal isOpen={isModalOpen} onClose={closeModal}>
                <h2>Votre ordonnance a bien été envoyé.</h2>
                <p>Le patient NUM {patient} a été notifié.</p>
            </Modal>
                {renderComponent()}
            </div>
            
        </div>
    );
};

export default DashboardDoc;