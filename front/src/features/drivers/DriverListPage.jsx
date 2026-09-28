import { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { getDrivers, deleteDriver } from '../../services/driversService';
import DriverTable from './components/DriverTable';
import styles from './DriverListPage.module.css';

export default function DriverListPage() {
  const [drivers, setDrivers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    loadDrivers();
  }, []);

  async function loadDrivers() {
    setLoading(true);
    setError(null);
    try {
      const data = await getDrivers();
      setDrivers(data);
    } catch (err) {
      setError('No se pudieron cargar los camioneros.');
    } finally {
      setLoading(false);
    }
  }

  async function handleDelete(driver) {
    const confirmar = window.confirm(
      `¿Seguro que querés eliminar a ${driver.nombre} ${driver.apellido}?`
    );
    if (!confirmar) return;

    try {
      await deleteDriver(driver.id);
      setDrivers((prev) => prev.filter((d) => d.id !== driver.id));
    } catch (err) {
      alert('No se pudo eliminar el camionero.');
    }
  }

  function handleEdit(driver) {
    navigate(`/drivers/${driver.id}/edit`);
  }

  return (
    <div className={styles.page}>
      <header className={styles.header}>
        <h1>Camioneros</h1>
        <Link to="/drivers/new" className={styles.newBtn}>
          + Nuevo camionero
        </Link>
      </header>

      {loading && <p className={styles.info}>Cargando camioneros...</p>}
      {error && <p className={styles.error}>{error}</p>}

      {!loading && !error && (
        <DriverTable
          drivers={drivers}
          onEdit={handleEdit}
          onDelete={handleDelete}
        />
      )}
    </div>
  );
}