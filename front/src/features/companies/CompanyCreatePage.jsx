import { Link, useNavigate } from 'react-router-dom';
import { createCompany } from '../../services/companiesService';
import CompanyForm from './components/CompanyForm';
import styles from './CompanyCreatePage.module.css';

export default function CompanyCreatePage() {
  const navigate = useNavigate();

  async function handleSubmit(form) {
    await createCompany(form);
    navigate('/companies');
  }

  return (
    <div className={styles.page}>
      <header className={styles.header}>
        <h1>Nueva empresa</h1>
        <Link to="/companies" className={styles.backBtn}>
          ← Volver
        </Link>
      </header>

      <CompanyForm
        onSubmit={handleSubmit}
        submitLabel="Crear empresa"
      />
    </div>
  );
}