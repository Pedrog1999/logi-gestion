import { NavLink, Link } from 'react-router-dom';
import styles from '../header/Header.module.css';

const NAV_ITEMS = [
  { to: '/companies', label: 'Empresas' },
  { to: '/drivers',   label: 'Camioneros' },
  { to: '/loads',     label: 'Cargas' },
  { to: '/trips',     label: 'Viajes' },
];

export default function Header() {
  return (
    <header className={styles.header}>
      <div className={styles.left}>
        <span className={styles.brand}>LogiGestión</span>
      </div>

      <nav className={styles.nav}>
        {NAV_ITEMS.map((item) => (
          <NavLink
            key={item.to}
            to={item.to}
            className={({ isActive }) =>
              isActive ? `${styles.link} ${styles.active}` : styles.link
            }
          >
            {item.label}
          </NavLink>
        ))}
      </nav>

      <div className={styles.right}>
        <Link to="/login" className={styles.loginBtn}>
          Iniciar sesión
        </Link>
      </div>
    </header>
  );
}