import { Link, useNavigate } from 'react-router-dom';
import { createDriver } from '../../services/driversService';
import DriverForm from './components/DriverForm';
import styles from './DriverCreatePage.module.css';

export default function DriverCreatePage() {
  const navigate = useNavigate();

  async function handleSubmit(form) {
    await createDriver(form);
    navigate('/drivers');
  }

  return (
    <div className={styles.page}>
      <header className={styles.header}>
        <h1>Nuevo camionero</h1>
        <Link to="/drivers" className={styles.backBtn}>
          ← Volver
        </Link>
      </header>

      <DriverForm
        onSubmit={handleSubmit}
        submitLabel="Crear camionero"
      />
    </div>
  );
}