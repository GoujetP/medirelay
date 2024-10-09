import React, { useState } from 'react';
import background from '../../../assets/img/background-home.png';
import docteurs from '../../../assets/img/docteurs.png';
import { useNavigate } from 'react-router-dom';
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
        expirationDate.setTime(expirationDate.getTime() + (60 * 60 * 1000)); // 1 hour
        const token = 'eyJhbGciOiJIUzI1NiJ9.eyJwYXNzd29yZCI6InJvb3QiLCJlbWFpbCI6InBpZXJyZS5nb3VqZXRAZWNvbGVzLWVwc2kubmV0In0.UNz83QQ-0AYLxhSBPziQzEMoDloxuDTuq-8XFfbsW8Y'
        document.cookie = `jwtTokenDoc=${token}; expires=${expirationDate.toUTCString()}; path=/`;

        const doctorId = '12345';
        navigate(`/dashboard-doc/${doctorId}`);
    };

    return (
        <>
        <div className='container-img-home'>
            <img src={background} alt="" className='background-home' />
            <img src={docteurs} alt="" className='docteurs' />
        </div>
        <div className='container-form-login'>
                <h2>Bonjour Docteur, connectez-vous !</h2>
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