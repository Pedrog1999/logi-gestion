import { useState, useRef, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import TruckScene from '../components/TruckScene/TruckScene';
import styles from './Login.module.css';

const MODE_KEY = 'login_scene_mode';

export default function Login() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [submitting, setSubmitting] = useState(false);
  const [sceneState, setSceneState] = useState('idle');
  const [mode, setMode] = useState(() => {
    return localStorage.getItem(MODE_KEY) || 'night';
  });

  const { login } = useAuth();
  const navigate = useNavigate();
  const shakeTimer = useRef(null);
  const audioCtxRef = useRef(null);

  useEffect(() => {
    localStorage.setItem(MODE_KEY, mode);
  }, [mode]);

  const toggleMode = () => {
    setMode((m) => (m === 'night' ? 'day' : 'night'));
  };

 const playHorn = () => {
  try {
    const Ctx = window.AudioContext || window.webkitAudioContext;
    if (!Ctx) return;

    if (!audioCtxRef.current) {
      audioCtxRef.current = new Ctx();
    }
    const ctx = audioCtxRef.current;
    if (ctx.state === 'suspended') {
      ctx.resume();
    }

    const now = ctx.currentTime;
    const duration = 0.7;

    // Filtro pasa-bajos: saca los agudos que lastiman
    const lowpass = ctx.createBiquadFilter();
    lowpass.type = 'lowpass';
    lowpass.frequency.setValueAtTime(650, now);
    lowpass.Q.setValueAtTime(1.2, now);

    // Envolvente master (más suave)
    const master = ctx.createGain();
    master.gain.setValueAtTime(0, now);
    master.gain.linearRampToValueAtTime(0.12, now + 0.05);
    master.gain.setValueAtTime(0.12, now + duration - 0.15);
    master.gain.linearRampToValueAtTime(0, now + duration);

    lowpass.connect(master);
    master.connect(ctx.destination);

    // Frecuencias más graves y cercanas entre sí
    const freqs = [130, 155];
    freqs.forEach((f) => {
      const osc = ctx.createOscillator();
      osc.type = 'triangle';   // ← triangle en vez de sawtooth: mucho más suave
      osc.frequency.setValueAtTime(f, now);
      osc.connect(lowpass);
      osc.start(now);
      osc.stop(now + duration);
    });
  } catch {
    // silencioso
  }
};

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setSubmitting(true);

    try {
      await login(username.trim(), password);
      navigate('/admin');
    } catch (err) {
      setError(err.message || 'No se pudo iniciar sesión');
      setSceneState('error');
      clearTimeout(shakeTimer.current);
      shakeTimer.current = setTimeout(() => setSceneState('idle'), 450);
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <div className={styles.page}>
      <TruckScene state={sceneState} mode={mode} />

      <div className={styles.sceneControls}>
        <button
          type="button"
          className={styles.sceneBtn}
          onClick={toggleMode}
          aria-label={mode === 'night' ? 'Cambiar a modo día' : 'Cambiar a modo noche'}
          title={mode === 'night' ? 'Modo día' : 'Modo noche'}
        >
          {mode === 'night' ? (
            // Sol
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round">
              <circle cx="12" cy="12" r="4" />
              <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
            </svg>
          ) : (
            // Luna
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
          )}
        </button>

        <button
          type="button"
          className={styles.sceneBtn}
          onClick={playHorn}
          aria-label="Tocar bocina"
          title="Bocina"
        >
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round">
            <path d="M11 5 6 9H2v6h4l5 4V5z" />
            <path d="M15.54 8.46a5 5 0 0 1 0 7.07" />
            <path d="M19.07 4.93a10 10 0 0 1 0 14.14" />
          </svg>
        </button>
      </div>

      <div className={styles.card}>
        <div className={styles.brand}>
          <h1 className={styles.title}>LogiGestión</h1>
          <p className={styles.subtitle}>Accedé al panel de administración</p>
        </div>

        <form className={styles.form} onSubmit={handleSubmit}>
          <label className={styles.field}>
            <span>Usuario</span>
            <input
              type="text"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              placeholder="Usuario Asignado"
              autoComplete="username"
              autoFocus
              required
            />
          </label>

          <label className={styles.field}>
            <span>Contraseña</span>
            <input
              type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              placeholder="••••••••"
              autoComplete="current-password"
              required
            />
          </label>

          {error && <p className={styles.error}>{error}</p>}

          <button
            type="submit"
            className={styles.submitBtn}
            disabled={submitting}
          >
            {submitting ? 'Entrando...' : 'Iniciar sesión'}
          </button>
        </form>
      </div>
    </div>
  );
}