import styles from './DriverTable.module.css';

export default function DriverTable({ drivers, onEdit, onDelete }) {
  if (drivers.length === 0) {
    return <p className={styles.empty}>No hay camioneros cargados.</p>;
  }

  return (
    <table className={styles.table}>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Teléfono</th>
          <th>Licencia</th>
          <th className={styles.actionsHeader}>Acciones</th>
        </tr>
      </thead>
      <tbody>
        {drivers.map((driver) => (
          <tr key={driver.id}>
            <td>{driver.nombre}</td>
            <td>{driver.apellido}</td>
            <td>{driver.telefono}</td>
            <td>{driver.licencia}</td>
            <td className={styles.actions}>
              <button
                className={styles.editBtn}
                onClick={() => onEdit(driver)}
              >
                Editar
              </button>
              <button
                className={styles.deleteBtn}
                onClick={() => onDelete(driver)}
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