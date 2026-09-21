import { Outlet } from 'react-router-dom';
import Header from '../shared/components/header/Header';
import Footer from '../shared/components/footer/Footer';
import styles from './MainLayout.module.css';

export default function MainLayout() {
  return (
    <div className={styles.container}>
      <Header />
      <main className={styles.main}>
        <Outlet />
      </main>
      <Footer />
    </div>
  );
}