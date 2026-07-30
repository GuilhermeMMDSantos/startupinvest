import { createContext, useContext, useState, type ReactNode } from 'react';
import { api } from '../lib/api';

export type Role = 'ADMIN' | 'INVESTOR' | 'STARTUP_OWNER';

export interface AuthUser {
  userId: number;
  email: string;
  role: Role;
  status: string;
}

interface AuthContextValue {
  user: AuthUser | null;
  login: (email: string, password: string) => Promise<AuthUser>;
  loginWithToken: (accessToken: string, user: AuthUser) => void;
  logout: () => void;
}

const AuthContext = createContext<AuthContextValue | undefined>(undefined);

function readStoredUser(): AuthUser | null {
  const raw = localStorage.getItem('authUser');
  if (!raw) return null;
  try {
    return JSON.parse(raw) as AuthUser;
  } catch {
    return null;
  }
}

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<AuthUser | null>(readStoredUser());

  function persist(accessToken: string, authUser: AuthUser) {
    localStorage.setItem('accessToken', accessToken);
    localStorage.setItem('authUser', JSON.stringify(authUser));
    setUser(authUser);
  }

  async function login(email: string, password: string) {
    const { data } = await api.post('/auth/login', { email, password });
    const authUser: AuthUser = { userId: data.userId, email: data.email, role: data.role, status: data.status };
    persist(data.accessToken, authUser);
    return authUser;
  }

  function loginWithToken(accessToken: string, authUser: AuthUser) {
    persist(accessToken, authUser);
  }

  function logout() {
    localStorage.removeItem('accessToken');
    localStorage.removeItem('authUser');
    setUser(null);
  }

  return (
    <AuthContext.Provider value={{ user, login, loginWithToken, logout }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const ctx = useContext(AuthContext);
  if (!ctx) throw new Error('useAuth deve ser usado dentro de AuthProvider');
  return ctx;
}
