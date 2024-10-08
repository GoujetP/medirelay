import React, { useState } from 'react';
import MenuItem from './Menu-item/MenuItem';
import logo from '../../assets/img/logo-menu.png';
import {useNavigate} from 'react-router-dom';
import { IoIosLogOut } from "react-icons/io";   
import './Menu.css';
const Menu = ({tabMenu, onMenuItemClick}) => {
    const [activeItem, setActiveItem] = useState(null);
    const navigate = useNavigate();
    const handleMenuItemClick = (index) => {
        setActiveItem(index);
    };
    const handleCookieDeletion = () => {
        document.cookie = 'jwtTokenDoc=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
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
                <MenuItem icon={<IoIosLogOut />} libelle='Déconnexion' onClick={() => { handleMenuItemClick(null); onMenuItemClick(null); handleCookieDeletion();navigate("/");}} isActive={false} />
            </div>
            <div className='separator'></div>
        </div>
        </>
    );
};

export default Menu;