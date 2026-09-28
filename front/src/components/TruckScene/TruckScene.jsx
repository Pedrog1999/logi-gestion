import styles from './TruckScene.module.css';

const TruckSvg = () => (
  <svg
    viewBox="0 0 100 32"
    className={styles.truckSvg}
    preserveAspectRatio="xMidYMid meet"
  >
    <rect x="0" y="6" width="62" height="18" rx="1.5" fill="#1b2334" />
    <line x1="4" y1="10.5" x2="58" y2="10.5" stroke="#2a3348" strokeWidth="0.6" />
    <rect x="4" y="17" width="54" height="3" rx="0.5" fill="#222c40" />

    <path d="M 62 10 L 76 10 L 84 16 L 84 24 L 62 24 Z" fill="#222c40" />
    <path d="M 76 11 L 82 16 L 76 16 Z" fill="#3d4a63" />
    <rect x="62" y="19.5" width="22" height="1.5" fill="#1b2334" />

    <circle cx="10" cy="26" r="3" fill="#050810" />
    <circle cx="24" cy="26" r="3" fill="#050810" />
    <circle cx="42" cy="26" r="3" fill="#050810" />
    <circle cx="54" cy="26" r="3" fill="#050810" />
    <circle cx="70" cy="26" r="3" fill="#050810" />
    <circle cx="80" cy="26" r="3" fill="#050810" />

    <circle cx="84" cy="20" r="2.8" fill="#fff6b0" opacity="0.3" />
    <circle cx="84" cy="20" r="1.1" fill="#fffce0" />

    <rect x="-2" y="19" width="3" height="1.2" fill="#ff4050" opacity="0.4" />
    <rect x="0" y="18" width="1.2" height="3.5" fill="#ff4050" />
  </svg>
);

const TRUCKS = [
  { lane: 'back',  speed: 24, delay: -4,  top: '6%',  scale: 0.6 },
  { lane: 'back',  speed: 30, delay: -18, top: '6%',  scale: 0.6 },
  { lane: 'back',  speed: 27, delay: -11, top: '6%',  scale: 0.6 },
  { lane: 'mid',   speed: 17, delay: -6,  top: '38%', scale: 0.85 },
  { lane: 'mid',   speed: 20, delay: -14, top: '38%', scale: 0.85 },
  { lane: 'front', speed: 11, delay: -2,  top: '70%', scale: 1.15 },
  { lane: 'front', speed: 13, delay: -8,  top: '70%', scale: 1.15 },
];

export default function TruckScene({ state = 'idle', mode = 'night' }) {
  return (
    <div className={styles.scene} data-state={state} data-mode={mode} aria-hidden="true">
      <div className={styles.sky} />
      <div className={styles.horizonGlow} />

      <div className={styles.highway}>
        <div className={styles.laneMarker} style={{ top: '22%' }} />
        <div className={styles.laneMarker} style={{ top: '54%' }} />
      </div>

      <div className={styles.trucks}>
        {TRUCKS.map((t, i) => (
          <div
            key={i}
            className={`${styles.truck} ${styles[t.lane]}`}
            style={{
              '--speed': `${t.speed}s`,
              '--delay': `${t.delay}s`,
              '--top': t.top,
              '--scale': t.scale,
            }}
          >
            <TruckSvg />
          </div>
        ))}
      </div>
    </div>
  );
}