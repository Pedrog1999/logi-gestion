import React, { useState } from 'react';
import styles from './admin.module.css';

const SECTIONS = [
  {
    id: 'usuarios',
    label: 'Usuarios',
    description: 'Cuentas con acceso al sistema y sus roles.',
    columns: ['ID', 'Usuario', 'Email', 'Rol', 'Alta'],
  },
  {
    id: 'choferes',
    label: 'Choferes',
    description: 'Conductores habilitados y su documentación.',
    columns: ['ID', 'Nombre', 'Licencia', 'Vencimiento', 'Estado'],
  },
  {
    id: 'viajes',
    label: 'Viajes',
    description: 'Viajes programados, en curso y finalizados.',
    columns: ['ID', 'Origen', 'Destino', 'Chofer', 'Estado', 'Fecha'],
  },
  {
    id: 'facturacion',
    label: 'Facturación',
    description: 'Comprobantes emitidos y su estado de cobro.',
    columns: ['ID', 'Comprobante', 'Empresa', 'Monto', 'Estado', 'Fecha'],
  },
  {
    id: 'cargas',
    label: 'Cargas',
    description: 'Cargas asociadas a los viajes.',
    columns: ['ID', 'Descripción', 'Peso', 'Viaje', 'Estado'],
  },
  {
    id: 'empresas',
    label: 'Empresas',
    description: 'Empresas clientes y sus datos de contacto.',
    columns: ['ID', 'Razón Social', 'CUIT', 'Contacto', 'Alta'],
  },
];

const Admin = () => {
  const [activeSection, setActiveSection] = useState('usuarios');

  const current = SECTIONS.find((s) => s.id === activeSection);

  return (
    <div className={styles.layout}>
      <aside className={styles.sidebar}>
        <div className={styles.brand}>
          <span className={styles.brandName}>Panel de Administración</span>
        </div>

        <nav className={styles.nav}>
          {SECTIONS.map((section) => (
            <button
              key={section.id}
              type="button"
              className={`${styles.navItem} ${
                activeSection === section.id ? styles.navItemActive : ''
              }`}
              onClick={() => setActiveSection(section.id)}
            >
              {section.label}
            </button>
          ))}
        </nav>
      </aside>

      <div className={styles.main}>
        <header className={styles.topbar}>
          <div>
            <h1 className={styles.pageTitle}>{current.label}</h1>
            <p className={styles.pageDescription}>{current.description}</p>
          </div>

          <div className={styles.topbarActions}>
            <button type="button" className={styles.secondaryBtn}>
              Exportar
            </button>
            <button type="button" className={styles.primaryBtn}>
              Nuevo
            </button>
          </div>
        </header>

        <section className={styles.content}>
          <div className={styles.toolbar}>
            <input
              type="text"
              placeholder={`Buscar en ${current.label.toLowerCase()}...`}
              className={styles.searchInput}
            />
            <select className={styles.filterSelect}>
              <option>Todos los estados</option>
            </select>
          </div>

          <div className={styles.tableWrapper}>
            <table className={styles.table}>
              <thead>
                <tr>
                  {current.columns.map((col) => (
                    <th key={col}>{col}</th>
                  ))}
                  <th className={styles.actionsCol}>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colSpan={current.columns.length + 1} className={styles.emptyState}>
                    Todavía no hay registros para mostrar.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <footer className={styles.pagination}>
            <span className={styles.paginationInfo}>0 resultados</span>
            <div className={styles.paginationControls}>
              <button type="button" className={styles.pageBtn} disabled>
                Anterior
              </button>
              <button type="button" className={styles.pageBtn} disabled>
                Siguiente
              </button>
            </div>
          </footer>
        </section>
      </div>
    </div>
  );
};

export default Admin;