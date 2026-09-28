// import api from './api';   // ← descomentar cuando el back esté listo

// ============================================================
// DATOS MOCK - temporal hasta que el back esté mergeado
// ============================================================
let DRIVERS_MOCK = [
  { id: 1, nombre: 'Juan',   apellido: 'Pérez',     telefono: '1122334455', licencia: 'A1-123456' },
  { id: 2, nombre: 'María',  apellido: 'Gómez',     telefono: '1155667788', licencia: 'B2-654321' },
  { id: 3, nombre: 'Carlos', apellido: 'Rodríguez', telefono: '1199887766', licencia: 'C3-112233' },
  { id: 4, nombre: 'Lucía',  apellido: 'Fernández', telefono: '1144556677', licencia: 'A1-998877' },
  { id: 5, nombre: 'Diego',  apellido: 'Martínez',  telefono: '1133221100', licencia: 'B2-445566' },
];
let nextId = 6;

// ============================================================
// VERSIONES MOCK (activas ahora)
// ============================================================

export async function getDrivers() {
  return Promise.resolve([...DRIVERS_MOCK]);
}

export async function getDriver(id) {
  const driver = DRIVERS_MOCK.find((d) => d.id === Number(id));
  if (!driver) throw new Error('Camionero no encontrado');
  return Promise.resolve(driver);
}

export async function createDriver(driver) {
  const nuevo = { ...driver, id: nextId++ };
  DRIVERS_MOCK.push(nuevo);
  return Promise.resolve(nuevo);
}

export async function updateDriver(id, driver) {
  const idx = DRIVERS_MOCK.findIndex((d) => d.id === Number(id));
  if (idx === -1) throw new Error('Camionero no encontrado');
  DRIVERS_MOCK[idx] = { ...DRIVERS_MOCK[idx], ...driver, id: Number(id) };
  return Promise.resolve(DRIVERS_MOCK[idx]);
}

export async function deleteDriver(id) {
  DRIVERS_MOCK = DRIVERS_MOCK.filter((d) => d.id !== Number(id));
  return Promise.resolve({ success: true });
}

// ============================================================
// VERSIONES REALES (descomentar cuando el back esté mergeado)
// ============================================================

// export async function getDrivers() {
//   const { data } = await api.get('/drivers');
//   return data;
// }

// export async function getDriver(id) {
//   const { data } = await api.get(`/drivers/${id}`);
//   return data;
// }

// export async function createDriver(driver) {
//   const { data } = await api.post('/drivers', driver);
//   return data;
// }

// export async function updateDriver(id, driver) {
//   const { data } = await api.put(`/drivers/${id}`, driver);
//   return data;
// }

// export async function deleteDriver(id) {
//   const { data } = await api.delete(`/drivers/${id}`);
//   return data;
// }