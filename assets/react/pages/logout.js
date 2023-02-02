import { useNavigate } from "react-router-dom";
import AuthenticatorServices from "../services/authenticatorServices";

const Logout = () => {

    let navigate = useNavigate();

    AuthenticatorServices.logout().then(isAuthenticated => {
        navigate('/login');
    });

}

export default Logout;