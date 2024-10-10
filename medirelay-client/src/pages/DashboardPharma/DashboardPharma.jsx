import React from 'react';
import { useState, useEffect } from 'react';
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
    const [listOrders, setListOrders] = useState([]);
    useEffect(() => {
        const fetchOrders = () => {
            try {
                const token = document.cookie.split('; ').find(row => row.startsWith('jwtTokenPharma=')).split('=')[1];
                if (!token) {
                    throw new Error('Token not found');
                }
                fetch(`http://localhost/medirelay-api/public/index.php/orders?role=Pharmacy&id=${pharmaId.pharmaId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).then(response => response.json()).then(data => setListOrders(data));
            } catch (error) {
                console.error('Error fetching patients:', error);
            }
        };

        if (pharmaId) {
            fetchOrders();
        } else {
            console.error('doctorId is not defined');
        }
    }, [pharmaId]);

    const handleMenuItemClick = (component) => {
        setSelectedComponent(component);
    };

    const renderComponent = () => {
            return <ListOrder list={listOrders} />;
    };
    console.log(listOrders);
    return (
        <div className='container-dashboard'>
            <Menu tabMenu={tabMenu} />
            <div className="dashboard-content">
                <h3>Bonjour, Pharmacie</h3>
                <h1>Les commandes en cours</h1>
                <div className="scrollable-list">
                    <ListOrder list={listOrders} onMenuItemClick={handleMenuItemClick} />
                </div>
            </div>
        </div>
    );
};

export default DashboardPharma;