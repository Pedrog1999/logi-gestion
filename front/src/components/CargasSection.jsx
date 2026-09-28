import React, { useState, useEffect } from 'react';
import styles from '../pages/admin.module.css';
import loadStyles from './CargasSection.module.css';
import { loadService } from '../services/loadService';

const CargasSection = () => {
  const [loads, setLoads] = useState([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [showModal, setShowModal] = useState(false);
  const [editingLoad, setEditingLoad] = useState(null);
  const [form, setForm] = useState({ type: '', name: '', commission: '' });
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState('');
  const [deleteConfirm, setDeleteConfirm] = useState(null);

  const fetchLoads = async () => {
    try {
      setLoading(true);
      const data = await loadService.getAll();
      setLoads(data);
    } catch (err) {
      setError('No se pudieron cargar los datos.');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchLoads();
  }, []);

  const filteredLoads = loads.filter(
    (load) =>
      load.name.toLowerCase().includes(search.toLowerCase()) ||
      load.type.toLowerCase().includes(search.toLowerCase())
  );

  const openCreate = () => {
    setEditingLoad(null);
    setForm({ type: '', name: '', commission: '' });
    setError('');
    setShowModal(true);
  };

  const openEdit = (load) => {
    setEditingLoad(load);
    setForm({
      type: load.type,
      name: load.name,
      commission: load.commission,
    });
    setError('');
    setShowModal(true);
  };

  const closeModal = () => {
    setShowModal(false);
    setEditingLoad(null);
    setForm({ type: '', name: '', commission: '' });
    setError('');
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!form.type.trim() || !form.name.trim() || form.commission === '') {
      setError('Todos los campos son obligatorios.');
      return;
    }
    setSaving(true);
    setError('');
    try {
      const payload = {
        type: form.type.trim(),
        name: form.name.trim(),
        commission: parseFloat(form.commission),
      };
      if (editingLoad) {
        await loadService.update(editingLoad.id, payload);
      } else {
        await loadService.create(payload);
      }
      closeModal();
      await fetchLoads();
    } catch (err) {
      setError('Ocurrió un error al guardar.');
    } finally {
      setSaving(false);
    }
  };

  const handleDelete = async (id) => {
    try {
      await loadService.remove(id);
      setDeleteConfirm(null);
      await fetchLoads();
    } catch (err) {
      setError('No se pudo eliminar la carga.');
    }
  };

  return (
    <>
      {/* Topbar */}
      <header className={styles.topbar}>
        <div>
          <h1 className={styles.pageTitle}>Cargas</h1>
          <p className={styles.pageDescription}>
            Tipos de carga y sus comisiones asociadas.
          </p>
        </div>
        <div className={styles.topbarActions}>
          <button type="button" className={styles.primaryBtn} onClick={openCreate}>
            + Nueva Carga
          </button>
        </div>
      </header>

      {/* Content */}
      <section className={styles.content}>
        <div className={styles.toolbar}>
          <input
            type="text"
            placeholder="Buscar por nombre o tipo..."
            className={styles.searchInput}
            value={search}
            onChange={(e) => setSearch(e.target.value)}
          />
        </div>

        <div className={styles.tableWrapper}>
          <table className={styles.table}>
            <thead>
              <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Comisión</th>
                <th className={styles.actionsCol}>Acciones</th>
              </tr>
            </thead>
            <tbody>
              {loading ? (
                <tr>
                  <td colSpan={5} className={styles.emptyState}>
                    Cargando...
                  </td>
                </tr>
              ) : filteredLoads.length === 0 ? (
                <tr>
                  <td colSpan={5} className={styles.emptyState}>
                    {search
                      ? 'No se encontraron resultados.'
                      : 'Todavía no hay cargas registradas.'}
                  </td>
                </tr>
              ) : (
                filteredLoads.map((load) => (
                  <tr key={load.id}>
                    <td>{load.id}</td>
                    <td>
                      <span className={loadStyles.typeBadge}>{load.type}</span>
                    </td>
                    <td>{load.name}</td>
                    <td className={loadStyles.commission}>
                      {Number(load.commission).toLocaleString('es-AR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                      })}
                    </td>
                    <td className={loadStyles.actionsCell}>
                      <button
                        className={loadStyles.editBtn}
                        onClick={() => openEdit(load)}
                        title="Editar"
                      >
                        ✏️
                      </button>
                      <button
                        className={loadStyles.deleteBtn}
                        onClick={() => setDeleteConfirm(load)}
                        title="Eliminar"
                      >
                        🗑️
                      </button>
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>

        <footer className={styles.pagination}>
          <span className={styles.paginationInfo}>
            {filteredLoads.length} resultado{filteredLoads.length !== 1 ? 's' : ''}
          </span>
        </footer>
      </section>

      {/* Modal Crear / Editar */}
      {showModal && (
        <div className={loadStyles.overlay} onClick={closeModal}>
          <div className={loadStyles.modal} onClick={(e) => e.stopPropagation()}>
            <div className={loadStyles.modalHeader}>
              <h2 className={loadStyles.modalTitle}>
                {editingLoad ? 'Editar Carga' : 'Nueva Carga'}
              </h2>
              <button className={loadStyles.closeBtn} onClick={closeModal}>
                ✕
              </button>
            </div>
            <form onSubmit={handleSubmit}>
              <div className={loadStyles.formGroup}>
                <label className={loadStyles.label}>Tipo</label>
                <input
                  type="text"
                  className={loadStyles.input}
                  placeholder="Ej: Granel, Refrigerada..."
                  value={form.type}
                  onChange={(e) => setForm({ ...form, type: e.target.value })}
                />
              </div>
              <div className={loadStyles.formGroup}>
                <label className={loadStyles.label}>Nombre</label>
                <input
                  type="text"
                  className={loadStyles.input}
                  placeholder="Nombre de la carga"
                  value={form.name}
                  onChange={(e) => setForm({ ...form, name: e.target.value })}
                />
              </div>
              <div className={loadStyles.formGroup}>
                <label className={loadStyles.label}>Comisión ($)</label>
                <input
                  type="number"
                  step="0.01"
                  min="0"
                  className={loadStyles.input}
                  placeholder="0.00"
                  value={form.commission}
                  onChange={(e) =>
                    setForm({ ...form, commission: e.target.value })
                  }
                />
              </div>
              {error && <p className={loadStyles.error}>{error}</p>}
              <div className={loadStyles.modalActions}>
                <button
                  type="button"
                  className={loadStyles.cancelBtn}
                  onClick={closeModal}
                >
                  Cancelar
                </button>
                <button
                  type="submit"
                  className={loadStyles.saveBtn}
                  disabled={saving}
                >
                  {saving
                    ? 'Guardando...'
                    : editingLoad
                    ? 'Guardar Cambios'
                    : 'Crear Carga'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {/* Modal Confirmar Eliminar */}
      {deleteConfirm && (
        <div className={loadStyles.overlay} onClick={() => setDeleteConfirm(null)}>
          <div className={loadStyles.modal} onClick={(e) => e.stopPropagation()}>
            <div className={loadStyles.modalHeader}>
              <h2 className={loadStyles.modalTitle}>Confirmar Eliminación</h2>
            </div>
            <p className={loadStyles.deleteText}>
              ¿Estás seguro de que deseas eliminar la carga{' '}
              <strong>"{deleteConfirm.name}"</strong>? Esta acción no se puede
              deshacer.
            </p>
            <div className={loadStyles.modalActions}>
              <button
                type="button"
                className={loadStyles.cancelBtn}
                onClick={() => setDeleteConfirm(null)}
              >
                Cancelar
              </button>
              <button
                type="button"
                className={loadStyles.dangerBtn}
                onClick={() => handleDelete(deleteConfirm.id)}
              >
                Sí, Eliminar
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
};

export default CargasSection;
