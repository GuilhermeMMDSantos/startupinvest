import { useEffect, useState } from 'react';
import { api, apiErrorMessage, fileUrl } from '../../lib/api';
import type { StartupDto } from '../../types';

export default function AdminStartups() {
  const [startups, setStartups] = useState<StartupDto[]>([]);
  const [filter, setFilter] = useState<'PENDING_APPROVAL' | 'APPROVED' | 'REJECTED' | ''>('PENDING_APPROVAL');
  const [notes, setNotes] = useState<Record<number, string>>({});
  const [error, setError] = useState<string | null>(null);

  function load() {
    api.get('/admin/startups', { params: filter ? { status: filter } : {} }).then(({ data }) => setStartups(data));
  }

  useEffect(load, [filter]);

  async function decide(id: number, approve: boolean) {
    setError(null);
    try {
      await api.post(`/admin/startups/${id}/decision`, { approve, notes: notes[id] ?? '' });
      load();
    } catch (err) {
      setError(apiErrorMessage(err));
    }
  }

  return (
    <div className="max-w-4xl mx-auto px-4 py-10 space-y-4">
      <h1 className="text-2xl font-bold">Aprovação de startups</h1>
      {error && <p className="text-red-600 text-sm">{error}</p>}
      <div className="flex gap-2">
        {(['PENDING_APPROVAL', 'APPROVED', 'REJECTED', ''] as const).map((s) => (
          <button key={s} onClick={() => setFilter(s)} className={filter === s ? 'btn-primary py-1' : 'btn-secondary py-1'}>
            {s || 'Todas'}
          </button>
        ))}
      </div>
      <div className="space-y-3">
        {startups.map((s) => (
          <div key={s.id} className="card">
            <div className="flex justify-between items-start">
              <div>
                <p className="font-semibold">{s.name}</p>
                <p className="text-sm text-slate-500">NIF {s.nif} · {s.sector ?? 'sem setor'}</p>
                <p className="text-xs text-slate-500">{s.shortDescription}</p>
              </div>
              <span className="badge bg-slate-100 text-slate-700">{s.status}</span>
            </div>
            <a className="text-brand-700 text-sm font-medium" href={fileUrl(s.pitchDeckPath)} target="_blank" rel="noreferrer">
              Ver pitch deck
            </a>
            {s.status === 'PENDING_APPROVAL' && (
              <div className="mt-3 flex gap-2 items-center">
                <input
                  className="input"
                  placeholder="Notas (opcional)"
                  value={notes[s.id] ?? ''}
                  onChange={(e) => setNotes({ ...notes, [s.id]: e.target.value })}
                />
                <button className="btn-primary" onClick={() => decide(s.id, true)}>
                  Aprovar
                </button>
                <button className="btn-danger" onClick={() => decide(s.id, false)}>
                  Rejeitar
                </button>
              </div>
            )}
          </div>
        ))}
        {startups.length === 0 && <p className="text-sm text-slate-500">Sem startups para mostrar.</p>}
      </div>
    </div>
  );
}
