import React from 'react';
import './MenuItem.css';

const MenuItem = ({ icon, libelle, onClick, isActive }) => {
    return (
        <div
            onClick={onClick}
            style={{ cursor: 'pointer' }}
            className={`container-menu-item ${isActive ? 'active' : ''}`}
        >
            <div className={`menu-item-icon ${isActive ? 'active' : ''}`}>{icon}</div>
            <p className={isActive ? 'active-text' : ''}>{libelle}</p>
        </div>
    );
};

export default MenuItem;