import React from 'react';

// import { Navigate, Routes as SwitchRoutes } from 'react-router-dom';
import { Navigate, Route, Routes as SwitchRoutes } from 'react-router-dom';

// import Route from './Route';

import AppPage from 'components/AppPage';

import { useAuth } from '../hooks/auth';
import Dashboard from '../pages/Dashboard';
import SignIn from '../pages/SignIn';
import SignUp from '../pages/SignUp';


const protect = (element: JSX.Element) => {
  // eslint-disable-next-line react-hooks/rules-of-hooks
  const { user } = useAuth();

  return !!user 
    ? <AppPage>{element}</AppPage> 
    : <Navigate to={'/sign-in'}/>;
}

const Routes: React.FC = () => (
  <SwitchRoutes>
    <Route path="/" element={<SignIn />} />
    <Route path="/sign-up" element={<SignUp />} />
    
    <Route path="/dashboard" element={protect(<Dashboard />)} />
    
    <Route path="*" element={<Navigate to={'/'}/>} />
  </SwitchRoutes>
);

export default Routes;
