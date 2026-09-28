import { useNavigate } from 'react-router-dom';
import styles from './LandingPage.module.css';

const LandingPage = () => {
  const navigate = useNavigate();

  return (
    <div className={styles.page}>
      <div className={styles.grid} aria-hidden="true" />

      <header className={styles.header}>
        <span className={styles.brand}>LogiGestión</span>
      </header>

      <main className={styles.main}>
        <span className={styles.eyebrow}>Panel de administración</span>

        <h1 className={styles.title}>
          Gestión de logística
          <br />
          <span className={styles.titleAccent}>sin fricción.</span>
        </h1>

        <p className={styles.lead}>
          Usuarios, choferes, viajes y cargas en un solo lugar.
          <br />
          Sin hojas de cálculo. Sin planillas perdidas.
        </p>

        <div className={styles.actions}>
          <button
            type="button"
            className={styles.primaryBtn}
            onClick={() => navigate('/login')}
          >
            Acceder al panel
            <span className={styles.arrow}>→</span>
          </button>
        </div>
      </main>

      <footer className={styles.footer}>
        <span>© {new Date().getFullYear()} LogiGestión</span>
        <span className={styles.dot} />
        <span>v1.0</span>
      </footer>
    </div>
  );
};

export default LandingPage;