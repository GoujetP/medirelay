import { Route, Routes} from 'react-router-dom';
import Home from '../../pages/Home/Home';
import LoginDocteur from '../../pages/Login/log-doc/Login.doc';
import LoginPatient from '../../pages/Login/log-patient/Login.patient';
import LoginPharma from '../../pages/Login/log-pharma/Login.pharma';

const Navigator = () => {
    return (
        <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/login-doc" element={<LoginDocteur />} />
            <Route path="/login-patient" element={<LoginPatient />} />
            <Route path="/login-pharma" element={<LoginPharma />} />
        </Routes>
    );
};

export default Navigator;

