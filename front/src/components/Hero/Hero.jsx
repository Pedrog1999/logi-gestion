import React from 'react';
import styles from './Hero.module.css';
import heroBg from '../../assets/camiones.png';

const Hero = () => {
  return (
    <section id="hero" className={styles.hero}>
      {/* Imagen como elemento HTML */}
      <img src={heroBg} alt="Camiones" className={styles.heroImage} />
      
      <div className={styles.overlay}></div>
      <div className={styles.container}>
        <div className={styles.content}>
          <h1 className={styles.title}>
            Gestión de <span className={styles.highlight}>Viajes</span> y <br />
            <span className={styles.highlight}>Flotas</span> de Camiones
          </h1>
          <p className={styles.subtitle}>
            Optimiza la logística de tu empresa con nuestra plataforma integral. 
            Controla viajes, conductores y mantenimiento en un solo lugar.
          </p>
          <div className={styles.buttons}>
            <button className={styles.primaryBtn}>Comenzar Ahora</button>
            <button className={styles.secondaryBtn}>Ver Demo</button>
          </div>
          <div className={styles.stats}>
            <div className={styles.stat}>
              <span className={styles.statNumber}>500+</span>
              <span className={styles.statLabel}>Empresas Confían</span>
            </div>
            <div className={styles.stat}>
              <span className={styles.statNumber}>10K+</span>
              <span className={styles.statLabel}>Viajes Completados</span>
            </div>
            <div className={styles.stat}>
              <span className={styles.statNumber}>98%</span>
              <span className={styles.statLabel}>Satisfacción</span>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Hero;