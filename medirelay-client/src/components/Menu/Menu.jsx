import React, { useState } from 'react';
import MenuItem from './Menu-item/MenuItem';
import logo from '../../assets/img/logo-menu.png';
import './Menu.css';
const Menu = ({tabMenu, onMenuItemClick}) => {
    const [activeItem, setActiveItem] = useState(null);
    const handleMenuItemClick = (index) => {
        setActiveItem(index);
    };

    return (
        <>
        <div className="container-menu" style={{ display: 'flex' }}>
            <div>
                <img src={logo} alt="logo" />
            </div>
            <div className='container-list-menu-item'>
                {tabMenu.map((menuItem, index) => (
                    <MenuItem
                        key={index}
                        icon={menuItem.icon}
                        libelle={menuItem.libelle}
                        onClick={() => { handleMenuItemClick(index);
                            onMenuItemClick(menuItem.component); }}
                        isActive={activeItem === index}
                    />
                ))}
            </div>
            <div className='separator'></div>
        </div>
        </>
    );
};

export default Menu;