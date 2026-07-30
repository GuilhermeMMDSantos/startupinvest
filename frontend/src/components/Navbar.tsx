import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { useEffect, useState } from 'react';
import { api } from '../lib/api';

export default function Navbar() {
  const { user, logout } = useAuth();
  const navigate = useNavigate();
  const [unread, setUnread] = useState(0);

  useEffect(() => {
    if (!user) return;
    let active = true;
    async function poll() {
      try {
        const { data } = await api.get('/notifications/unread-count');
        if (active) setUnread(data.unread);
      } catch {
        /* ignore */
      }
    }
    poll();
    const id = setInterval(poll, 15000);
    return () => {
      active = false;
      clearInterval(id);
    };
  }, [user]);

  function dashboardHome() {
    if (!user) return '/';
    if (user.role === 'ADMIN') return '/admin';
    if (user.role === 'STARTUP_OWNER') return '/startup';
    return '/investor';
  }

  return (
    <header className="bg-white border-b border-slate-200 sticky top-0 z-10">
      <div className="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between">
        <Link to="/" className="font-bold text-brand-700 text-lg">
          StartupInvest
        </Link>
        <nav className="flex items-center gap-4 text-sm">
          <Link to="/rounds" className="text-slate-600 hover:text-brand-700">
            Rodadas
          </Link>
          {user ? (
            <>
              <Link to={dashboardHome()} className="text-slate-600 hover:text-brand-700">
                Painel
              </Link>
              <Link to="/notifications" className="relative text-slate-600 hover:text-brand-700">
                Notificações
                {unread > 0 && (
                  <span className="absolute -top-2 -right-3 bg-red-500 text-white text-[10px] rounded-full px-1.5">
                    {unread}
                  </span>
                )}
              </Link>
              <button
                onClick={() => {
                  logout();
                  navigate('/');
                }}
                className="btn-secondary py-1"
              >
                Sair
              </button>
            </>
          ) : (
            <>
              <Link to="/login" className="btn-secondary py-1">
                Entrar
              </Link>
              <Link to="/register" className="btn-primary py-1">
                Registar
              </Link>
            </>
          )}
        </nav>
      </div>
    </header>
  );
}
