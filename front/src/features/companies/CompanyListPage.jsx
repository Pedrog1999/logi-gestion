import { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { getCompanies, deleteCompany } from '../../services/companiesService';
import CompanyTable from './components/CompanyTable';
import styles from './CompanyListPage.module.css';

export default function CompanyListPage() {
  const [companies, setCompanies] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    loadCompanies();
  }, []);

  async function loadCompanies() {
    setLoading(true);
    setError(null);
    try {
      const data = await getCompanies();
      setCompanies(data);
    } catch (err) {
      setError('No se pudieron cargar las empresas.');
    } finally {
      setLoading(false);
    }
  }

  async function handleDelete(company) {
    const confirmar = window.confirm(
      `¿Seguro que querés eliminar a ${company.nombre}?`
    );
    if (!confirmar) return;

    try {
      await deleteCompany(company.id);
      setCompanies((prev) => prev.filter((c) => c.id !== company.id));
    } catch (err) {
      alert('No se pudo eliminar la empresa.');
    }
  }

  function handleEdit(company) {
    navigate(`/companies/${company.id}/edit`);
  }

  return (
    <div className={styles.page}>
      <header className={styles.header}>
        <h1>Empresas</h1>
        <Link to="/companies/new" className={styles.newBtn}>
          + Nueva empresa
        </Link>
      </header>

      {loading && <p className={styles.info}>Cargando empresas...</p>}
      {error && <p className={styles.error}>{error}</p>}

      {!loading && !error && (
        <CompanyTable
          companies={companies}
          onEdit={handleEdit}
          onDelete={handleDelete}
        />
      )}
    </div>
  );
}