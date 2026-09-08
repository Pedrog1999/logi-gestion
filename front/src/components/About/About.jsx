import React from 'react';
import styles from './About.module.css';

const About = () => {
  return (
    <section id="about" className={styles.about}>
      <div className={styles.container}>
        <div className={styles.content}>
          <h2 className={styles.title}>
            ¿Quiénes <span className={styles.highlight}>Somos</span>?
          </h2>
          <p className={styles.paragraph}>
            Somos una plataforma innovadora dedicada a revolucionar la gestión de flotas de camiones y 
            viajes logísticos. Con años de experiencia en el sector, entendemos los desafíos diarios que 
            enfrentan las empresas de transporte.
          </p>
          <p className={styles.paragraph}>
            Nuestra misión es proporcionar herramientas tecnológicas que simplifiquen y optimicen cada 
            aspecto de la operación logística, desde la planificación hasta la ejecución, permitiendo a 
            nuestros clientes enfocarse en lo que realmente importa: hacer crecer su negocio.
          </p>
          <div className={styles.values}>
            <div className={styles.valueItem}>
              <span className={styles.valueIcon}>🎯</span>
              <div>
                <h4>Misión</h4>
                <p>Transformar la logística de transporte mediante tecnología de vanguardia.</p>
              </div>
            </div>
            <div className={styles.valueItem}>
              <span className={styles.valueIcon}>👁️</span>
              <div>
                <h4>Visión</h4>
                <p>Ser la plataforma líder en gestión de flotas en América Latina.</p>
              </div>
            </div>
            <div className={styles.valueItem}>
              <span className={styles.valueIcon}>💎</span>
              <div>
                <h4>Valores</h4>
                <p>Innovación, confianza, eficiencia y compromiso con nuestros clientes.</p>
              </div>
            </div>
          </div>
        </div>
        <div className={styles.imageWrapper}>
          <div className={styles.imagePlaceholder}>
            <span>🚛</span>
          </div>
        </div>
      </div>
    </section>
  );
};

export default About;