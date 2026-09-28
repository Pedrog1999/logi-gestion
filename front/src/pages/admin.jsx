import { useState, useEffect, useCallback } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { userService } from '../services/UserService';
import { ApiError } from '../services/api';
import styles from './admin.module.css';
import CargasSection from '../components/CargasSection';

const SECTIONS = [
  {
    id: 'usuarios',
    label: 'Usuarios',
    description: 'Cuentas con acceso al sistema y sus roles.',
    columns: ['ID', 'Usuario', 'Email', 'Rol', 'Estado', 'Alta'],
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
    description: 'Tipos de carga y sus comisiones asociadas.',
    columns: ['ID', 'Tipo', 'Nombre', 'Comisión'],
  },
  {
    id: 'empresas',
    label: 'Empresas',
    description: 'Empresas clientes y sus datos de contacto.',
    columns: ['ID', 'Razón Social', 'CUIT', 'Contacto', 'Alta'],
  },
];

const ROLE_LABELS = {
  user: 'Usuario',
  admin: 'Administrador',
};

const EMPTY_FORM = {
  username: '',
  email: '',
  role: 'user',
  password: '',
};

const formatDate = (iso) => {
  if (!iso) return '—';
  try {
    return new Date(iso).toLocaleDateString('es-AR', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
    });
  } catch {
    return '—';
  }
};

const Admin = () => {
  const [activeSection, setActiveSection] = useState('usuarios');
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(false);
  const [listError, setListError] = useState('');
  const [actionError, setActionError] = useState('');
  const [busyUserId, setBusyUserId] = useState(null);

  const [isModalOpen, setIsModalOpen] = useState(false);
  const [formData, setFormData] = useState(EMPTY_FORM);
  const [formError, setFormError] = useState('');
  const [fieldErrors, setFieldErrors] = useState({});
  const [submitting, setSubmitting] = useState(false);

  const { user: currentUser, logout } = useAuth();
  const isAdmin = currentUser?.role === 'admin';
  const navigate = useNavigate();

  const current = SECTIONS.find((s) => s.id === activeSection);
  const isUsersSection = activeSection === 'usuarios';

  const loadUsers = useCallback(async () => {
    setLoading(true);
    setListError('');
    try {
      const data = await userService.getAll();
      setUsers(Array.isArray(data) ? data : []);
    } catch (err) {
      setListError(err.message || 'No se pudieron cargar los usuarios');
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    if (isUsersSection) {
      loadUsers();
    }
  }, [isUsersSection, loadUsers]);

  const openModal = () => {
    setFormData(EMPTY_FORM);
    setFormError('');
    setFieldErrors({});
    setIsModalOpen(true);
  };

  const closeModal = () => {
    if (submitting) return;
    setIsModalOpen(false);
    setFormError('');
    setFieldErrors({});
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
    setFieldErrors((prev) => ({ ...prev, [name]: undefined }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setFormError('');
    setFieldErrors({});

    if (!formData.username.trim() || !formData.email.trim() || !formData.password) {
      setFormError('Completá usuario, email y contraseña.');
      return;
    }

    setSubmitting(true);
    try {
      const created = await userService.create({
        username: formData.username.trim(),
        email: formData.email.trim(),
        password: formData.password,
        role: formData.role,
      });
      setUsers((prev) => [...prev, created]);
      setIsModalOpen(false);
      setFormData(EMPTY_FORM);
    } catch (err) {
      if (err instanceof ApiError && err.errors) {
        setFieldErrors(err.errors);
      }
      setFormError(err.message || 'No se pudo crear el usuario');
    } finally {
      setSubmitting(false);
    }
  };

  const handleToggleActive = async (u) => {
    setActionError('');
    setBusyUserId(u.id);
    try {
      const updated = u.active
        ? await userService.deactivate(u.id)
        : await userService.activate(u.id);
      setUsers((prev) => prev.map((x) => (x.id === u.id ? updated : x)));
    } catch (err) {
      setActionError(err.message || 'No se pudo cambiar el estado del usuario');
    } finally {
      setBusyUserId(null);
    }
  };

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

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

        <div className={styles.sidebarFooter}>
          <div className={styles.sidebarUser}>
            <span className={styles.sidebarUserName}>{currentUser?.username}</span>
            <span className={styles.sidebarUserRole}>
              {ROLE_LABELS[currentUser?.role] || currentUser?.role}
            </span>
          </div>
          <button
            type="button"
            className={styles.logoutBtn}
            onClick={handleLogout}
          >
            Cerrar sesión
          </button>
        </div>
      </aside>

      <div className={styles.main}>
        <header className={styles.topbar}>
          <div>
            <h1 className={styles.pageTitle}>{current.label}</h1>
            <p className={styles.pageDescription}>{current.description}</p>
          </div>

          <div className={styles.topbarActions}>
            {isUsersSection && (
              <button
                type="button"
                className={styles.primaryBtn}
                onClick={openModal}
                disabled={!isAdmin}
                title={
                  !isAdmin
                    ? 'Solo administradores pueden crear usuarios'
                    : undefined
                }
              >
                Nuevo usuario
              </button>
            )}
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

          {actionError && (
            <div className={styles.listError} role="alert">
              {actionError}
            </div>
          )}

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
                {isUsersSection ? (
                  loading ? (
                    <tr>
                      <td
                        colSpan={current.columns.length + 1}
                        className={styles.emptyState}
                      >
                        Cargando usuarios...
                      </td>
                    </tr>
                  ) : listError ? (
                    <tr>
                      <td
                        colSpan={current.columns.length + 1}
                        className={styles.emptyState}
                      >
                        {listError}
                      </td>
                    </tr>
                  ) : users.length === 0 ? (
                    <tr>
                      <td
                        colSpan={current.columns.length + 1}
                        className={styles.emptyState}
                      >
                        Todavía no hay usuarios para mostrar.
                      </td>
                    </tr>
                  ) : (
                    users.map((u) => {
                      const isSelf = currentUser?.id === u.id;
                      const isBusy = busyUserId === u.id;

                      return (
                        <tr key={u.id}>
                          <td>{u.id}</td>
                          <td>{u.username}</td>
                          <td>{u.email}</td>
                          <td>{ROLE_LABELS[u.role] || u.role}</td>
                          <td>
                            <span
                              className={`${styles.statusBadge} ${
                                u.active ? styles.statusActive : styles.statusInactive
                              }`}
                            >
                              {u.active ? 'Activo' : 'Inactivo'}
                            </span>
                          </td>
                          <td>{formatDate(u.createdAt)}</td>
                          <td className={styles.actionsCol}>
                            <button
                              type="button"
                              className={
                                u.active ? styles.dangerBtn : styles.secondaryBtn
                              }
                              onClick={() => handleToggleActive(u)}
                              disabled={!isAdmin || isSelf || isBusy}
                              title={
                                !isAdmin
                                  ? 'Solo administradores pueden modificar usuarios'
                                  : isSelf
                                  ? 'No podés desactivar tu propia cuenta'
                                  : u.active
                                  ? 'Desactivar usuario'
                                  : 'Activar usuario'
                              }
                            >
                              {isBusy
                                ? '...'
                                : u.active
                                ? 'Desactivar'
                                : 'Activar'}
                            </button>
                          </td>
                        </tr>
                      );
                    })
                  )
                ) : (
                  <tr>
                    <td
                      colSpan={current.columns.length + 1}
                      className={styles.emptyState}
                    >
                      Todavía no hay registros para mostrar.
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>

          <footer className={styles.pagination}>
            <span className={styles.paginationInfo}>
              {isUsersSection ? `${users.length} resultados` : '0 resultados'}
            </span>
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

      {isModalOpen && (
        <div className={styles.modalOverlay} onClick={closeModal}>
          <div
            className={styles.modal}
            onClick={(e) => e.stopPropagation()}
            role="dialog"
            aria-modal="true"
          >
            <header className={styles.modalHeader}>
              <h2 className={styles.modalTitle}>Nuevo usuario</h2>
              <button
                type="button"
                className={styles.modalClose}
                onClick={closeModal}
                aria-label="Cerrar"
                disabled={submitting}
              >
                ×
              </button>
            </header>

            <form className={styles.modalForm} onSubmit={handleSubmit}>
              <label className={styles.formField}>
                <span>Usuario</span>
                <input
                  type="text"
                  name="username"
                  value={formData.username}
                  onChange={handleChange}
                  placeholder="jperez"
                  autoFocus
                  disabled={submitting}
                />
                {fieldErrors.username && (
                  <span className={styles.fieldError}>{fieldErrors.username}</span>
                )}
              </label>

              <label className={styles.formField}>
                <span>Email</span>
                <input
                  type="email"
                  name="email"
                  value={formData.email}
                  onChange={handleChange}
                  placeholder="jperez@empresa.com"
                  disabled={submitting}
                />
                {fieldErrors.email && (
                  <span className={styles.fieldError}>{fieldErrors.email}</span>
                )}
              </label>

              <label className={styles.formField}>
                <span>Rol</span>
                <select
                  name="role"
                  value={formData.role}
                  onChange={handleChange}
                  disabled={submitting}
                >
                  <option value="user">Usuario</option>
                  <option value="admin">Administrador</option>
                </select>
                {fieldErrors.role && (
                  <span className={styles.fieldError}>{fieldErrors.role}</span>
                )}
              </label>

              <label className={styles.formField}>
                <span>Contraseña</span>
                <input
                  type="password"
                  name="password"
                  value={formData.password}
                  onChange={handleChange}
                  placeholder="Mínimo 8 caracteres"
                  disabled={submitting}
                />
                {fieldErrors.password && (
                  <span className={styles.fieldError}>{fieldErrors.password}</span>
                )}
              </label>

              {formError && <p className={styles.formError}>{formError}</p>}

              <div className={styles.modalActions}>
                <button
                  type="button"
                  className={styles.secondaryBtn}
                  onClick={closeModal}
                  disabled={submitting}
                >
                  Cancelar
                </button>
                <button
                  type="submit"
                  className={styles.primaryBtn}
                  disabled={submitting}
                >
                  {submitting ? 'Creando...' : 'Crear usuario'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default Admin;
