import { useState, useEffect } from 'react';
import styles from './DriverForm.module.css';

const EMPTY = {
  nombre: '',
  apellido: '',
  telefono: '',
  licencia: '',
};

export default function DriverForm({ initialData, onSubmit, submitLabel }) {
  const [form, setForm] = useState(EMPTY);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (initialData) {
      setForm(initialData);
    } else {
      setForm(EMPTY);
    }
  }, [initialData]);

  function handleChange(e) {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  }

  async function handleSubmit(e) {
    e.preventDefault();
    setError(null);
    setLoading(true);
    try {
      await onSubmit(form);
    } catch (err) {
      setError(err?.response?.data?.message || 'Ocurrió un error. Intentá de nuevo.');
    } finally {
      setLoading(false);
    }
  }

  return (
    <form className={styles.form} onSubmit={handleSubmit}>
      <div className={styles.field}>
        <label htmlFor="nombre">Nombre</label>
        <input
          id="nombre"
          name="nombre"
          type="text"
          value={form.nombre}
          onChange={handleChange}
          required
          maxLength={100}
        />
      </div>

      <div className={styles.field}>
        <label htmlFor="apellido">Apellido</label>
        <input
          id="apellido"
          name="apellido"
          type="text"
          value={form.apellido}
          onChange={handleChange}
          required
          maxLength={100}
        />
      </div>

      <div className={styles.field}>
        <label htmlFor="telefono">Teléfono</label>
        <input
          id="telefono"
          name="telefono"
          type="text"
          value={form.telefono}
          onChange={handleChange}
          required
          maxLength={30}
        />
      </div>

      <div className={styles.field}>
        <label htmlFor="licencia">Licencia</label>
        <input
          id="licencia"
          name="licencia"
          type="text"
          value={form.licencia}
          onChange={handleChange}
          required
          maxLength={30}
        />
      </div>

      {error && <p className={styles.error}>{error}</p>}

      <div className={styles.actions}>
        <button type="submit" className={styles.submitBtn} disabled={loading}>
          {loading ? 'Guardando...' : submitLabel}
        </button>
      </div>
    </form>
  );
}