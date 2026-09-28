const API_BASE = 'http://localhost:8000/api';

export const loadService = {
  async getAll() {
    const res = await fetch(`${API_BASE}/loads`);
    if (!res.ok) throw new Error('Error al obtener las cargas');
    return res.json();
  },

  async getById(id) {
    const res = await fetch(`${API_BASE}/load/${id}`);
    if (!res.ok) throw new Error('Error al obtener la carga');
    return res.json();
  },

  async create(data) {
    const res = await fetch(`${API_BASE}/load`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    if (!res.ok) throw new Error('Error al crear la carga');
    return res.json();
  },

  async update(id, data) {
    const res = await fetch(`${API_BASE}/load/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    if (!res.ok) throw new Error('Error al actualizar la carga');
    return res.json();
  },

  async remove(id) {
    const res = await fetch(`${API_BASE}/load/${id}`, {
      method: 'DELETE',
    });
    if (!res.ok) throw new Error('Error al eliminar la carga');
    return res.json();
  },
};
