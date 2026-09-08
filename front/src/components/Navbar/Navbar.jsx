import React, { useState } from 'react';
import styles from './Navbar.module.css';

const Navbar = ({ onOpenModal }) => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen);
  };

  const scrollToSection = (id) => {
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
    setIsMenuOpen(false);
  };

  return (
    <nav className={styles.navbar}>
      <div className={styles.container}>
        <div className={styles.logo}>
          <span className={styles.logoIcon}></span>
          <span className={styles.logoText}>Logi<span className={styles.logoAccent}>Gestión</span></span>
        </div>

        <div className={`${styles.menuButton} ${isMenuOpen ? styles.active : ''}`} onClick={toggleMenu}>
          <span></span>
          <span></span>
          <span></span>
        </div>

        <ul className={`${styles.navLinks} ${isMenuOpen ? styles.open : ''}`}>
          <li><a href="#hero" onClick={() => scrollToSection('hero')}>Inicio</a></li>
          <li><a href="#features" onClick={() => scrollToSection('features')}>Servicios</a></li>
          <li><a href="#about" onClick={() => scrollToSection('about')}>Quiénes Somos</a></li>
          <li><a href="#testimonials" onClick={() => scrollToSection('testimonials')}>Testimonios</a></li>
          <li className={styles.authButtons}>
            <button 
              className={`${styles.btn} ${styles.btnLogin}`}
              onClick={() => onOpenModal('login')}
            >
              Iniciar Sesión
            </button>
            <button 
              className={`${styles.btn} ${styles.btnRegister}`}
              onClick={() => onOpenModal('register')}
            >
              Registrarse
            </button>
          </li>
        </ul>
      </div>
    </nav>
  );
};

export default Navbar;