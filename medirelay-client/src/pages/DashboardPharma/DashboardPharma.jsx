import React from 'react';
import { useState } from 'react';
import { useParams } from 'react-router-dom';
import Menu from '../../components/Menu/Menu';
import { IoMdReorder } from "react-icons/io";
import ListOrder from '../../components/List-Patients/ListOrder';
const DashboardPharma = () => {
    const pharmaId = useParams();
    const [selectedComponent, setSelectedComponent] = useState('');
    const tabMenu = [
        {
            icon: <IoMdReorder />,
            libelle: 'Commandes en cours',
            component: 'ListOrder'
        }
    ];
    const data = [
        {
            docteur: { name: 'Olivier Dupont' },
            ordo: { id: 1 },
            patient: { nom: 'Martin', prenom: 'Jean' }
        },
        {
            docteur: { name: 'Marc Martin' },
            ordo: { id: 2 },
            patient: { nom: 'Durand', prenom: 'Marie' }
        },
        {
            docteur: { name: 'Jean-Charles Durand' },
            ordo: { id: 3 },
            patient: { nom: 'Petit', prenom: 'Luc' }
        },
        {
            docteur: { name: 'Sophie Bernard' },
            ordo: { id: 4 },
            patient: { nom: 'Moreau', prenom: 'Emma' }
        },
        {
            docteur: { name: 'Claire Lefevre' },
            ordo: { id: 5 },
            patient: { nom: 'Fournier', prenom: 'Paul' }
        },
        {
            docteur: { name: 'Claire Lefevre' },
            ordo: { id: 5 },
            patient: { nom: 'Fournier', prenom: 'Paul' }
        }
    ];

    const handleMenuItemClick = (component) => {
        setSelectedComponent(component);
    };

    const renderComponent = () => {
            return <ListOrder list={data} />;
    };
    return (
        <div className='container-dashboard'>
            <Menu tabMenu={tabMenu} />
            <div className="dashboard-content">
                <h3>Bonjour, Pharmacie</h3>
                <h1>Les commandes en cours</h1>
                <div className="scrollable-list">
                    <ListOrder list={data} onMenuItemClick={handleMenuItemClick} />
                </div>
            </div>
        </div>
    );
};

export default DashboardPharma;