import React from 'react';
import styles from './Footer.module.css';

const Footer = () => {
  return (
    <footer className={styles.footer}>
      <div className={styles.container}>
        <div className={styles.grid}>
          <div className={styles.column}>
            <h3 className={styles.logo}>Transport<span>GO</span></h3>
            <p className={styles.description}>
              La plataforma líder en gestión de flotas de camiones y logística de transporte.
            </p>
          </div>
          <div className={styles.column}>
            <h4>Enlaces Rápidos</h4>
            <ul>
              <li><a href="#hero">Inicio</a></li>
              <li><a href="#features">Servicios</a></li>
              <li><a href="#about">Quiénes Somos</a></li>
              <li><a href="#testimonials">Testimonios</a></li>
            </ul>
          </div>
          <div className={styles.column}>
            <h4>Contacto</h4>
            <ul>
              <li>📞 +54 11 1234-5678</li>
              <li>✉️ info@transportgo.com</li>
              <li>📍 Buenos Aires, Argentina</li>
            </ul>
          </div>
          <div className={styles.column}>
            <h4>Síguenos</h4>
            <div className={styles.social}>
              <a href="#" className={styles.socialIcon}>📱</a>
              <a href="#" className={styles.socialIcon}>🐦</a>
              <a href="#" className={styles.socialIcon}>📷</a>
              <a href="#" className={styles.socialIcon}>💼</a>
            </div>
          </div>
        </div>
        <div className={styles.bottom}>
          <p>© 2024 TransportGO - Todos los derechos reservados</p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;