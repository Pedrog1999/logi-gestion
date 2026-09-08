import React from 'react';
import styles from './Testimonials.module.css';

const Testimonials = () => {
  const testimonials = [
    {
      name: 'Carlos Rodríguez',
      role: 'Director de Logística',
      company: 'Transportes del Norte',
      text: 'Esta plataforma revolucionó la forma en que gestionamos nuestra flota. Hemos aumentado nuestra eficiencia en un 40% y reducido costos operativos significativamente.',
      rating: 5,
      avatar: '👨‍💼'
    },
    {
      name: 'María González',
      role: 'Gerente de Operaciones',
      company: 'Carga Express',
      text: 'La facilidad de uso y las herramientas de seguimiento en tiempo real nos han permitido mejorar la comunicación con nuestros conductores y clientes.',
      rating: 5,
      avatar: '👩‍💼'
    },
    {
      name: 'Juan Pérez',
      role: 'Dueño de Flota',
      company: 'Transportes del Sur',
      text: 'Increíble herramienta. El mantenimiento programado y los reportes nos ayudan a tomar mejores decisiones para nuestra flota de 50 camiones.',
      rating: 5,
      avatar: '👨‍✈️'
    }
  ];

  return (
    <section id="testimonials" className={styles.testimonials}>
      <div className={styles.container}>
        <div className={styles.header}>
          <h2 className={styles.title}>Lo que dicen <span className={styles.highlight}>nuestros clientes</span></h2>
          <p className={styles.subtitle}>Experiencias reales de empresas que confían en nosotros</p>
        </div>
        <div className={styles.grid}>
          {testimonials.map((testimonial, index) => (
            <div key={index} className={styles.card}>
              <div className={styles.rating}>
                {'⭐'.repeat(testimonial.rating)}
              </div>
              <p className={styles.text}>"{testimonial.text}"</p>
              <div className={styles.author}>
                <div className={styles.avatar}>{testimonial.avatar}</div>
                <div>
                  <h4 className={styles.name}>{testimonial.name}</h4>
                  <p className={styles.role}>{testimonial.role} - {testimonial.company}</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Testimonials;