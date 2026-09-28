// import api from './api';   // ← descomentar cuando el back esté listo

// ============================================================
// DATOS MOCK - temporal hasta que el back esté mergeado
// ============================================================
let COMPANIES_MOCK = [
  { id: 1, nombre: 'Transportes Norte S.A.', cuit: '30-71234567-8', telefono: '1145678900', email: 'contacto@tnorte.com', direccion: 'Av. Rivadavia 1234, CABA' },
  { id: 2, nombre: 'Logística Sur SRL',      cuit: '30-70987654-3', telefono: '1145678911', email: 'info@logsur.com',    direccion: 'Ruta 3 Km 45, La Plata' },
  { id: 3, nombre: 'Cargas del Oeste',       cuit: '30-70555444-1', telefono: '1145678922', email: 'ventas@cargasoeste.com', direccion: 'Av. Gaona 5500, Morón' },
  { id: 4, nombre: 'Express Cuyo',           cuit: '30-70111222-9', telefono: '1145678933', email: 'contacto@expresscuyo.com', direccion: 'San Martín 800, Mendoza' },
  { id: 5, nombre: 'Andes Transporte',       cuit: '30-70333444-5', telefono: '1145678944', email: 'info@andestrans.com', direccion: 'Belgrano 200, Salta' },
];
let nextId = 6;

// ============================================================
// VERSIONES MOCK (activas ahora)
// ============================================================

export async function getCompanies() {
  return Promise.resolve([...COMPANIES_MOCK]);
}

export async function getCompany(id) {
  const company = COMPANIES_MOCK.find((c) => c.id === Number(id));
  if (!company) throw new Error('Empresa no encontrada');
  return Promise.resolve(company);
}

export async function createCompany(company) {
  const nueva = { ...company, id: nextId++ };
  COMPANIES_MOCK.push(nueva);
  return Promise.resolve(nueva);
}

export async function updateCompany(id, company) {
  const idx = COMPANIES_MOCK.findIndex((c) => c.id === Number(id));
  if (idx === -1) throw new Error('Empresa no encontrada');
  COMPANIES_MOCK[idx] = { ...COMPANIES_MOCK[idx], ...company, id: Number(id) };
  return Promise.resolve(COMPANIES_MOCK[idx]);
}

export async function deleteCompany(id) {
  COMPANIES_MOCK = COMPANIES_MOCK.filter((c) => c.id !== Number(id));
  return Promise.resolve({ success: true });
}

// ============================================================
// VERSIONES REALES (descomentar cuando el back esté mergeado)
// ============================================================

// export async function getCompanies() {
//   const { data } = await api.get('/companies');
//   return data;
// }

// export async function getCompany(id) {
//   const { data } = await api.get(`/companies/${id}`);
//   return data;
// }

// export async function createCompany(company) {
//   const { data } = await api.post('/companies', company);
//   return data;
// }

// export async function updateCompany(id, company) {
//   const { data } = await api.put(`/companies/${id}`, company);
//   return data;
// }

// export async function deleteCompany(id) {
//   const { data } = await api.delete(`/companies/${id}`);
//   return data;
// }