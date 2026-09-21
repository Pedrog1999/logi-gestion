import styles from './Footer.module.css';

export default function Footer() {
  return (
    <footer className={styles.footer}>
      <p>© {new Date().getFullYear()} LogiGestión — Todos los derechos reservados</p>
    </footer>
  );
}