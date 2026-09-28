const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';
const TOKEN_KEY = 'auth_token';

let unauthorizedHandler = null;

export function setUnauthorizedHandler(handler) {
  unauthorizedHandler = handler;
}

export function getToken() {
  return localStorage.getItem(TOKEN_KEY);
}

export function setToken(token) {
  localStorage.setItem(TOKEN_KEY, token);
}

export function clearToken() {
  localStorage.removeItem(TOKEN_KEY);
}

export class ApiError extends Error {
  constructor(status, code, message, errors = null) {
    super(message);
    this.status = status;
    this.code = code;
    this.errors = errors;
  }
}

export async function apiFetch(path, options = {}) {
  const token = getToken();
  const headers = {
    'Content-Type': 'application/json',
    ...(options.headers || {}),
  };

  if (token) {
    headers.Authorization = `Bearer ${token}`;
  }

  const response = await fetch(`${API_URL}${path}`, {
    ...options,
    headers,
  });

  if (response.status === 204) {
    return null;
  }

  const text = await response.text();
  let body = null;
  if (text) {
    try {
      body = JSON.parse(text);
    } catch {
      body = { raw: text };
    }
  }

  if (!response.ok) {
    const err = body?.error || {};
    const code = err.code || 'unknown_error';
    const message = err.message || `Error ${response.status}`;

    const tokenErrors = ['token_expired', 'token_invalid', 'token_missing', 'session_invalid'];
    if (response.status === 401 && tokenErrors.includes(code)) {
      clearToken();
      if (unauthorizedHandler) unauthorizedHandler();
    }

    throw new ApiError(response.status, code, message, err.errors);
  }

  return body?.data ?? body;
}