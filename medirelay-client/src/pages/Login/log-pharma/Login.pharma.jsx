import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import background from '../../../assets/img/background-home.png';
import docteurs from '../../../assets/img/docteurs.png';
import '../Login.css';
const LoginDocteur = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();
    const handleEmailChange = (e) => {
        setEmail(e.target.value);
    };

    const handlePasswordChange = (e) => {
        setPassword(e.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const expirationDate = new Date();
        expirationDate.setTime(expirationDate.getTime() + (60 * 60 * 1000));
        const token = 'eyJhbGciOiJIUzI1NiJ9.eyJwYXNzd29yZCI6InJvb3QiLCJlbWFpbCI6InBpZXJyZS5nb3VqZXRAZWNvbGVzLWVwc2kubmV0In0.UNz83QQ-0AYLxhSBPziQzEMoDloxuDTuq-8XFfbsW8Y'
        document.cookie = `jwtTokenPharma=${token}; expires=${expirationDate.toUTCString()}; path=/`;

        const pharmaId = '12345';
        navigate(`/dashboard-pharma/${pharmaId}`);
    };

    return (
        <>
        <div className='container-img-home'>
            <img src={background} alt="" className='background-home' />
            <img src={docteurs} alt="" className='docteurs' />
        </div>
        <div className='container-form-login'>
                <h2>Vous êtes une pharmacie, connectez-vous !</h2>
                <form onSubmit={handleSubmit}>
                    <div className='container-input'>
                        <label htmlFor="email">Email:</label>
                        <input
                            type="email"
                            id="email"
                            value={email}
                            onChange={handleEmailChange} />
                    </div>
                    <div className='container-input'>
                        <label htmlFor="password">Mot de passe:</label>
                        <input
                            type="password"
                            id="password"
                            value={password}
                            onChange={handlePasswordChange} />
                    </div>
                    <button type="submit" className='button-form-login'>Se connecter</button>
                </form>
            </div>
        </>
    );
};

export default LoginDocteur;