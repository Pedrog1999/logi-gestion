import { useState, useEffect } from 'react';
import styles from './CompanyForm.module.css';

const EMPTY = {
  nombre: '',
  cuit: '',
  telefono: '',
  email: '',
  direccion: '',
};

export default function CompanyForm({ initialData, onSubmit, submitLabel }) {
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
          maxLength={150}
        />
      </div>

      <div className={styles.field}>
        <label htmlFor="cuit">CUIT</label>
        <input
          id="cuit"
          name="cuit"
          type="text"
          value={form.cuit}
          onChange={handleChange}
          required
          maxLength={20}
          placeholder="30-12345678-9"
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
        <label htmlFor="email">Email</label>
        <input
          id="email"
          name="email"
          type="email"
          value={form.email}
          onChange={handleChange}
          required
          maxLength={150}
        />
      </div>

      <div className={styles.field}>
        <label htmlFor="direccion">Dirección</label>
        <input
          id="direccion"
          name="direccion"
          type="text"
          value={form.direccion}
          onChange={handleChange}
          required
          maxLength={200}
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