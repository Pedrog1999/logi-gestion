import React, { useEffect } from 'react';
import styles from './Modal.module.css';

const Modal = ({ isOpen, onClose, type, onSwitchType }) => {
  useEffect(() => {
    const handleEsc = (e) => {
      if (e.key === 'Escape') onClose();
    };
    document.addEventListener('keydown', handleEsc);
    return () => document.removeEventListener('keydown', handleEsc);
  }, [onClose]);

  if (!isOpen) return null;

  const handleOverlayClick = (e) => {
    if (e.target === e.currentTarget) onClose();
  };

  return (
    <div className={styles.modalOverlay} onClick={handleOverlayClick}>
      <div className={styles.modal}>
        <button className={styles.closeBtn} onClick={onClose}>✕</button>
        
        <div className={styles.modalContent}>
          <h2 className={styles.modalTitle}>
            {type === 'login' ? 'Iniciar Sesión' : 'Registrarse'}
          </h2>
          
          <form className={styles.form}>
            {type === 'register' && (
              <>
                <div className={styles.formGroup}>
                  <label>Nombre Completo</label>
                  <input type="text" placeholder="Juan Pérez" />
                </div>
                <div className={styles.formGroup}>
                  <label>Empresa</label>
                  <input type="text" placeholder="Transportes Ejemplo" />
                </div>
              </>
            )}
            
            <div className={styles.formGroup}>
              <label>Email</label>
              <input type="email" placeholder="ejemplo@empresa.com" />
            </div>
            
            <div className={styles.formGroup}>
              <label>Contraseña</label>
              <input type="password" placeholder="••••••••" />
            </div>
            
            {type === 'login' && (
              <div className={styles.formOptions}>
                <label className={styles.rememberMe}>
                  <input type="checkbox" /> Recordarme
                </label>
                <a href="#" className={styles.forgotPassword}>¿Olvidaste tu contraseña?</a>
              </div>
            )}
            
            <button type="submit" className={styles.submitBtn}>
              {type === 'login' ? 'Iniciar Sesión' : 'Crear Cuenta'}
            </button>
          </form>
          
          <div className={styles.switchAuth}>
            <p>
              {type === 'login' ? '¿No tienes cuenta?' : '¿Ya tienes cuenta?'}
              <button 
                className={styles.switchBtn}
                onClick={() => onSwitchType(type === 'login' ? 'register' : 'login')}
              >
                {type === 'login' ? 'Regístrate aquí' : 'Inicia sesión aquí'}
              </button>
            </p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Modal;