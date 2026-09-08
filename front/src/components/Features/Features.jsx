import React from 'react';
import styles from './Features.module.css';

const Features = () => {
  const features = [
    {
      icon: '',
      title: 'Gestión de Flotas',
      description: 'Controla todos tus camiones en tiempo real con mantenimiento programado y seguimiento de rendimiento.'
    },
    {
      icon: '',
      title: 'Planificación de Viajes',
      description: 'Organiza rutas optimizadas, asigna conductores y monitorea cada viaje desde el inicio hasta la entrega.'
    },
    {
      icon: '',
      title: 'Administración de Conductores',
      description: 'Gestiona licencias, certificaciones, disponibilidad y desempeño de tu equipo de conductores.'
    },
    {
      icon: '',
      title: 'Reportes y Análisis',
      description: 'Obtén insights valiosos con reportes detallados sobre eficiencia, costos y productividad.'
    },
    {
      icon: '',
      title: 'Mantenimiento Preventivo',
      description: 'Programa y da seguimiento al mantenimiento de tu flota para evitar tiempos de inactividad.'
    },
    {
      icon: '',
      title: 'Gestión de Documentos',
      description: 'Centraliza todos los documentos importantes: contratos, seguros, facturas y más.'
    }
  ];

  return (
    <section id="features" className={styles.features}>
      <div className={styles.container}>
        <div className={styles.header}>
          <h2 className={styles.title}>Servicios <span className={styles.highlight}>Especializados</span></h2>
          <p className={styles.subtitle}>
            Soluciones integrales para la gestión eficiente de tu flota de camiones
          </p>
        </div>
        <div className={styles.grid}>
          {features.map((feature, index) => (
            <div key={index} className={styles.card}>
              <div className={styles.iconWrapper}>{feature.icon}</div>
              <h3 className={styles.cardTitle}>{feature.title}</h3>
              <p className={styles.cardDescription}>{feature.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Features;