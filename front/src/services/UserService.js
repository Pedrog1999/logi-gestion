import { apiFetch } from './api';

export const userService = {
  getAll: () => apiFetch('/users'),
  getById: (id) => apiFetch(`/users/${id}`),
  create: (data) =>
    apiFetch('/users', {
      method: 'POST',
      body: JSON.stringify(data),
    }),
  update: (id, data) =>
    apiFetch(`/users/${id}`, {
      method: 'PATCH',
      body: JSON.stringify(data),
    }),
  deactivate: (id) => apiFetch(`/users/${id}`, { method: 'DELETE' }),
  activate: (id) => apiFetch(`/users/${id}/activate`, { method: 'PATCH' }),
};