import React, { useState } from 'react';
import background from '../../../assets/img/background-home.png';
import docteurs from '../../../assets/img/docteurs.png';
import '../Login.css';
import { useNavigate } from 'react-router-dom';
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
        fetch(`http://192.168.137.2/medirelay-api/public/index.php/login?username=${email}&password=${password}&role=Patient`, {
            method: 'GET',
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); // Change to text to handle empty responses
        })
        .then(text => {
            if (!text) {
                throw new Error('Empty response');
            }
            return JSON.parse(text); // Parse the text to JSON
        })
        .then(data => {
            if (data.token) {
                const expirationDate = new Date();
                expirationDate.setTime(expirationDate.getTime() + (60 * 60 * 1000));
                document.cookie = `jwtTokenPatient=${data.token}; expires=${expirationDate.toUTCString()}; path=/`;
                const patientId = data.id;
                navigate(`/dashboard-patient/${patientId}`);
            } else {
                console.error('Login failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };

    return (
        <>
        <div className='container-img-home'>
            <img src={background} alt="" className='background-home' />
            <img src={docteurs} alt="" className='docteurs' />
        </div>
        <div className='container-form-login'>
                <h2>Bonjour Madame/Monsieur, connectez-vous !</h2>
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