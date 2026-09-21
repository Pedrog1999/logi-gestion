import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import MainLayout from '../../layouts/MainLayoutt';
import LoginPage from '../../features/auth/LoginPage';
import CompanyListPage from '../../features/companies/CompanyListPage';
import DriverListPage from '../../features/drivers/DriverListPage';
import LoadListPage from '../../features/loads/LoadListPage';
import TripListPage from '../../features/trips/TripListPage';

export default function AppRouter() {
  return (
    <BrowserRouter>
      <Routes>

        {/* Públicas */}
        <Route element={<AuthLayout />}>
          <Route path="/login" element={<LoginPage />} />
        </Route>

        {/* Privadas */}
        <Route element={<MainLayout />}>
          <Route path="/companies" element={<CompanyListPage />} />
          <Route path="/drivers"   element={<DriverListPage />} />
          <Route path="/loads"     element={<LoadListPage />} />
          <Route path="/trips"     element={<TripListPage />} />
        </Route>

        {/* Raíz redirige a empresas */}
        <Route path="/" element={<Navigate to="/companies" replace />} />

      </Routes>
    </BrowserRouter>
  );
}