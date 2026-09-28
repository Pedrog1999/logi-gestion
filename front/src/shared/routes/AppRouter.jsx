import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';

import LandingPage from '../../pages/LandingPage';
import Login from '../../pages/login';
import Admin from '../../pages/admin';
import PrivateRoute from '../routes/PrivateRoute';

import MainLayout from '../../layouts/MainLayout';

import LoginPage from '../../features/auth/LoginPage';
import CompanyListPage from '../../features/companies/CompanyListPage';
import CompanyCreatePage from '../../features/companies/CompanyCreatePage';
import CompanyEditPage from '../../features/companies/CompanyEditPage';
import DriverListPage from '../../features/drivers/DriverListPage';
import DriverCreatePage from '../../features/drivers/DriverCreatePage';
import DriverEditPage from '../../features/drivers/DriverEditPage';
import LoadListPage from '../../features/loads/LoadListPage';
import TripListPage from '../../features/trips/TripListPage';

export default function AppRouter() {
  return (
    <BrowserRouter>
      <Routes>

        <Route path="/login" element={<Login />} />

        <Route element={<MainLayout />}>
          <Route path="/companies" element={<CompanyListPage />} />
          <Route path="/companies/new" element={<CompanyCreatePage />} />
          <Route path="/companies/:id/edit" element={<CompanyEditPage />} />

          <Route path="/drivers" element={<DriverListPage />} />
          <Route path="/drivers/new" element={<DriverCreatePage />} />
          <Route path="/drivers/:id/edit" element={<DriverEditPage />} />

          <Route path="/loads" element={<LoadListPage />} />
          <Route path="/trips" element={<TripListPage />} />
        </Route>

        <Route path="/" element={<Navigate to="/companies" replace />} />

        <Route
          path="/admin"
          element={
            <PrivateRoute>
              <Admin />
            </PrivateRoute>
          }
        />

        <Route path="*" element={<Navigate to="/" replace />} />

      </Routes>
    </BrowserRouter>
  );
}
