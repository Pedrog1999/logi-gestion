import { NavLink } from 'react-router-dom';
import logo from '../../assets/logo.png';
import styles from './Header.module.css';

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
        <img src={logo} alt="Logo" className={styles.logo} />
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
        {/* Aquí luego irá el usuario logueado, logout, etc. */}
      </div>
    </header>
  );
}