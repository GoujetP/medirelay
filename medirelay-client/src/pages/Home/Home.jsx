import React from 'react';
import background from '../../assets/img/background-home.png';
import docteurs from '../../assets/img/docteurs.png';
import { Link } from 'react-router-dom';
import './Home.css';
const Home = () => {
    return (
        
            <>
            <div className='container-img-home'>
            <img src={background} alt="" className='background-home' />
            <img src={docteurs} alt="" className='docteurs' />
        </div><div className='container-button-login'>
                <h1>Choisissez votre profil.</h1>
                <div className='navigation-buttons'>
                    <Link to='/login-doc' className='nav-button'>Docteur</Link>
                    <Link to='/login-patient' className='nav-button'>Patient</Link>
                    <Link to='/login-pharma' className='nav-button'>Pharmacie</Link>
                </div>
            </div></>
        
    );
};

export default Home;