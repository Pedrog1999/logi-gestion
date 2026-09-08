import React, { useState } from 'react';
import styles from './LandingPage.module.css';
import Navbar from '../components/Navbar/Navbar.jsx';  // ← .jsx
import Hero from '../components/Hero/Hero.jsx';        // ← .jsx
import Features from '../components/Features/Features.jsx'; // ← .jsx
import About from '../components/About/About.jsx';     // ← .jsx
import Testimonials from '../components/Testimonials/Testimonials.jsx'; // ← .jsx
import Footer from '../components/Footer/Footer.jsx';  // ← .jsx
import Modal from '../components/Modal/Modal.jsx';     // ← .jsx

const LandingPage = () => {
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [modalType, setModalType] = useState('login');

  const openModal = (type) => {
    setModalType(type);
    setIsModalOpen(true);
  };

  const closeModal = () => {
    setIsModalOpen(false);
  };

  return (
    <div className={styles.landingPage}>
      <Navbar onOpenModal={openModal} />
      <main>
        <Hero />
        <Features />
        <About />
        <Testimonials />
      </main>
      <Footer />
      <Modal 
        isOpen={isModalOpen} 
        onClose={closeModal} 
        type={modalType}
        onSwitchType={openModal}
      />
    </div>
  );
};

export default LandingPage;