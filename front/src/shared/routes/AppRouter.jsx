import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import MainLayout from '../../layouts/MainLayout';

import LoginPage from '../../features/auth/LoginPage';
import CompanyListPage from '../../features/companies/CompanyListPage';
import DriverListPage from '../../features/drivers/DriverListPage';
import DriverCreatePage from '../../features/drivers/DriverCreatePage';
import DriverEditPage from '../../features/drivers/DriverEditPage';
import LoadListPage from '../../features/loads/LoadListPage';
import TripListPage from '../../features/trips/TripListPage';


export default function AppRouter() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/login" element={<LoginPage />} />
        <Route element={<MainLayout />}>
          <Route path="/companies" element={<CompanyListPage />} />
          <Route path="/drivers"   element={<DriverListPage />} />
          <Route path="/loads"     element={<LoadListPage />} />
          <Route path="/trips"     element={<TripListPage />} />
          <Route path="/drivers/new" element={<DriverCreatePage />} />
          <Route path="/drivers/:id/edit" element={<DriverEditPage />} />
        </Route>

        <Route path="/" element={<Navigate to="/companies" replace />} />
      </Routes>
    </BrowserRouter>
  );
}