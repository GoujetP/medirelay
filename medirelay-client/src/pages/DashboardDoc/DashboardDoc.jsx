import React,{useState} from 'react';
import { useParams } from 'react-router-dom';
import Menu from '../../components/Menu/Menu';
import { FaUserMd, FaPrescriptionBottleAlt } from 'react-icons/fa';
import './Dashboard.css';
import Patients from '../../components/Patients/Patients';
import CreatePrescription from '../../components/CreatePrescription/CreatePrescription';
const DashboardDoc = () => {
    const { doctorId } = useParams();
    const [selectedComponent, setSelectedComponent] = useState('Patients');
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