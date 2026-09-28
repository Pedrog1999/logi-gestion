import styles from './CompanyTable.module.css';

export default function CompanyTable({ companies, onEdit, onDelete }) {
  if (companies.length === 0) {
    return <p className={styles.empty}>No hay empresas cargadas.</p>;
  }

  return (
    <table className={styles.table}>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>CUIT</th>
          <th>Teléfono</th>
          <th>Email</th>
          <th>Dirección</th>
          <th className={styles.actionsHeader}>Acciones</th>
        </tr>
      </thead>
      <tbody>
        {companies.map((company) => (
          <tr key={company.id}>
            <td>{company.nombre}</td>
            <td>{company.cuit}</td>
            <td>{company.telefono}</td>
            <td>{company.email}</td>
            <td>{company.direccion}</td>
            <td className={styles.actions}>
              <button
                className={styles.editBtn}
                onClick={() => onEdit(company)}
              >
                Editar
              </button>
              <button
                className={styles.deleteBtn}
                onClick={() => onDelete(company)}
              >
                Eliminar
              </button>
            </td>
          </tr>
        ))}
      </tbody>
    </table>
  );
}