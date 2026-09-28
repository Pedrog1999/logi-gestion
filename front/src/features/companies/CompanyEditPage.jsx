import { useEffect, useState } from 'react';
import { Link, useNavigate, useParams } from 'react-router-dom';
import { getCompany, updateCompany } from '../../services/companiesService';
import CompanyForm from './components/CompanyForm';
import styles from './CompanyEditPage.module.css';

export default function CompanyEditPage() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [company, setCompany] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    loadCompany();
  }, [id]);

  async function loadCompany() {
    setLoading(true);
    setError(null);
    try {
      const data = await getCompany(id);
      setCompany(data);
    } catch (err) {
      setError('No se pudo cargar la empresa.');
    } finally {
      setLoading(false);
    }
  }

  async function handleSubmit(form) {
    await updateCompany(id, form);
    navigate('/companies');
  }

  return (
    <div className={styles.page}>
      <header className={styles.header}>
        <h1>Editar empresa</h1>
        <Link to="/companies" className={styles.backBtn}>
          ← Volver
        </Link>
      </header>

      {loading && <p className={styles.info}>Cargando...</p>}
      {error && <p className={styles.error}>{error}</p>}

      {!loading && !error && company && (
        <CompanyForm
          initialData={company}
          onSubmit={handleSubmit}
          submitLabel="Guardar cambios"
        />
      )}
    </div>
  );
}