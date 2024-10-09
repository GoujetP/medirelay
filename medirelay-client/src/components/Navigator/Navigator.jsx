import { Route, Routes} from 'react-router-dom';
import Home from '../../pages/Home/Home';
import LoginDocteur from '../../pages/Login/log-doc/Login.doc';
import LoginPatient from '../../pages/Login/log-patient/Login.patient';
import LoginPharma from '../../pages/Login/log-pharma/Login.pharma';
import DashboardDoc from '../../pages/DashboardDoc/DashboardDoc';
import DashboardPatient from '../../pages/DashboardPatient/DashboardPatient';
import OrdoDetail from '../OrdoDetail/OrdoDetail';
import DashboardPharma from '../../pages/DashboardPharma/DashboardPharma';
const Navigator = () => {
    return (
        <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/login-doc" element={<LoginDocteur />} />
            <Route path="/login-patient" element={<LoginPatient />} />
            <Route path="/login-pharma" element={<LoginPharma />} />
            <Route path="/dashboard-doc/:doctorId" element={<DashboardDoc />} />
            <Route path="/dashboard-patient/:patientId" element={<DashboardPatient />} />
            <Route path="/dashboard-pharma/:pharmaId" element={<DashboardPharma />} />
            <Route path="/ordo-detail/:idPatient/:idOrdo" element={<OrdoDetail />} />
        </Routes>
    );
};

export default Navigator;

