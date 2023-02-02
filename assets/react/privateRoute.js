import React from 'react';
import { Navigate, Outlet } from 'react-router-dom';
import AuthenticatorServices from './services/authenticatorServices';

function PrivateRoute() {
    const isAuthenticated = AuthenticatorServices.isAuthenticated;

    return isAuthenticated ? <Outlet /> : <Navigate to="/login" />
}

export default PrivateRoute;


