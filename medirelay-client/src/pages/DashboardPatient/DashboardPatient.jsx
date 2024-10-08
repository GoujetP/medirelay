import React, { useState } from 'react';
import { useParams , useLocation} from 'react-router-dom';
import Menu from '../../components/Menu/Menu';
import { FaFilePrescription } from 'react-icons/fa';
import './DashboardPatient.css';
import Patients from '../../components/Patients/Patients';
import OrdoPatients from '../../components/OrdoPatients/OrdoPatients';
const DashboardDoc = () => {
    const { doctorId } = useParams();
    const location = useLocation();
    const queryParams = new URLSearchParams(location.search);
    const patient = queryParams.get('patient');
    let patientBoolean= patient ? true : false;
    const [selectedComponent, setSelectedComponent] = useState('Patients');
    const [isModalOpen, setIsModalOpen] = useState(patientBoolean);

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

    const closeModal = () => {
        setIsModalOpen(false);
    };

    return (
        <div className='container-dashboard'>
            <Menu tabMenu={tabMenu} onMenuItemClick={handleMenuItemClick} />
            <div className="dashboard-content">
                {renderComponent()}
            </div>
            
        </div>
    );
};

export default DashboardDoc;