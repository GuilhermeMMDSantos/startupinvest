import { useEffect, useState } from 'react';
import { api, apiErrorMessage } from '../../lib/api';
import type { UserSummaryDto } from '../../types';

type RoleFilter = 'ADMIN' | 'INVESTOR' | 'STARTUP_OWNER' | '';
type StatusFilter = 'PENDING_VERIFICATION' | 'ACTIVE' | 'SUSPENDED' | 'REJECTED' | '';

export default function AdminUsers() {
  const [users, setUsers] = useState<UserSummaryDto[]>([]);
  const [role, setRole] = useState<RoleFilter>('');
  const [status, setStatus] = useState<StatusFilter>('');
  const [notes, setNotes] = useState<Record<number, string>>({});
  const [error, setError] = useState<string | null>(null);

  function load() {
    api.get('/admin/users', { params: { ...(role ? { role } : {}), ...(status ? { status } : {}) } })
      .then(({ data }) => setUsers(data));
  }

  useEffect(load, [role, status]);

  async function updateStatus(id: number, nextStatus: 'ACTIVE' | 'SUSPENDED') {
    setError(null);
    try {
      await api.patch(`/admin/users/${id}/status`, { status: nextStatus, notes: notes[id] ?? '' });
      load();
    } catch (err) {
      setError(apiErrorMessage(err));
    }
  }

  return (
    <div className="max-w-5xl mx-auto px-4 py-10 space-y-4">
      <h1 className="text-2xl font-bold">Gestão de utilizadores</h1>
      {error && <p className="text-red-600 text-sm">{error}</p>}

      <div className="flex flex-wrap gap-2">
        {(['', 'ADMIN', 'INVESTOR', 'STARTUP_OWNER'] as const).map((value) => (
          <button key={value || 'all'} onClick={() => setRole(value)} className={role === value ? 'btn-primary py-1' : 'btn-secondary py-1'}>
            {value || 'Todos os papéis'}
          </button>
        ))}
      </div>

      <div className="flex flex-wrap gap-2">
        {(['', 'PENDING_VERIFICATION', 'ACTIVE', 'SUSPENDED', 'REJECTED'] as const).map((value) => (
          <button key={value || 'all-status'} onClick={() => setStatus(value)} className={status === value ? 'btn-primary py-1' : 'btn-secondary py-1'}>
            {value || 'Todos os estados'}
          </button>
        ))}
      </div>

      <div className="space-y-3">
        {users.map((user) => (
          <div key={user.id} className="card space-y-3">
            <div className="flex justify-between gap-4 items-start">
              <div>
                <p className="font-semibold">{user.email}</p>
                <p className="text-sm text-slate-500">{user.role} · criado em {new Date(user.createdAt).toLocaleString()}</p>
              </div>
              <span className="badge bg-slate-100 text-slate-700">{user.status}</span>
            </div>

            {user.role !== 'ADMIN' && (
              <div className="flex flex-wrap gap-2 items-center">
                <input
                  className="input"
                  placeholder="Notas (opcional)"
                  value={notes[user.id] ?? ''}
                  onChange={(e) => setNotes({ ...notes, [user.id]: e.target.value })}
                />
                {user.status !== 'ACTIVE' && (
                  <button className="btn-primary" onClick={() => updateStatus(user.id, 'ACTIVE')}>
                    Reativar
                  </button>
                )}
                {user.status !== 'SUSPENDED' && (
                  <button className="btn-danger" onClick={() => updateStatus(user.id, 'SUSPENDED')}>
                    Suspender
                  </button>
                )}
              </div>
            )}
          </div>
        ))}
        {users.length === 0 && <p className="text-sm text-slate-500">Sem utilizadores para mostrar.</p>}
      </div>
    </div>
  );
}