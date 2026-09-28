import { useEffect, useState } from 'react';
import { Link, useNavigate, useParams } from 'react-router-dom';
import { getDriver, updateDriver } from '../../services/driversService';
import DriverForm from './components/DriverForm';
import styles from './DriverEditPage.module.css';

export default function DriverEditPage() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [driver, setDriver] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    loadDriver();
  }, [id]);

  async function loadDriver() {
    setLoading(true);
    setError(null);
    try {
      const data = await getDriver(id);
      setDriver(data);
    } catch (err) {
      setError('No se pudo cargar el camionero.');
    } finally {
      setLoading(false);
    }
  }

  async function handleSubmit(form) {
    await updateDriver(id, form);
    navigate('/drivers');
  }

  return (
    <div className={styles.page}>
      <header className={styles.header}>
        <h1>Editar camionero</h1>
        <Link to="/drivers" className={styles.backBtn}>
          ← Volver
        </Link>
      </header>

      {loading && <p className={styles.info}>Cargando...</p>}
      {error && <p className={styles.error}>{error}</p>}

      {!loading && !error && driver && (
        <DriverForm
          initialData={driver}
          onSubmit={handleSubmit}
          submitLabel="Guardar cambios"
        />
      )}
    </div>
  );
}