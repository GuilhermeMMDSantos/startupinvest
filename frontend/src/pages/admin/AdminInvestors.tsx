import { useEffect, useState } from 'react';
import { api, apiErrorMessage, fileUrl } from '../../lib/api';
import type { InvestorProfileDto } from '../../types';

export default function AdminInvestors() {
  const [investors, setInvestors] = useState<InvestorProfileDto[]>([]);
  const [filter, setFilter] = useState<'PENDING' | 'APPROVED' | 'REJECTED' | ''>('PENDING');
  const [notes, setNotes] = useState<Record<number, string>>({});
  const [error, setError] = useState<string | null>(null);

  function load() {
    api.get('/admin/investors', { params: filter ? { status: filter } : {} }).then(({ data }) => setInvestors(data));
  }

  useEffect(load, [filter]);

  async function decide(id: number, approve: boolean) {
    setError(null);
    try {
      await api.post(`/admin/investors/${id}/decision`, { approve, notes: notes[id] ?? '' });
      load();
    } catch (err) {
      setError(apiErrorMessage(err));
    }
  }

  return (
    <div className="max-w-4xl mx-auto px-4 py-10 space-y-4">
      <h1 className="text-2xl font-bold">Verificação de investidores</h1>
      {error && <p className="text-red-600 text-sm">{error}</p>}
      <div className="flex gap-2">
        {(['PENDING', 'APPROVED', 'REJECTED', ''] as const).map((s) => (
          <button key={s} onClick={() => setFilter(s)} className={filter === s ? 'btn-primary py-1' : 'btn-secondary py-1'}>
            {s || 'Todos'}
          </button>
        ))}
      </div>
      <div className="space-y-3">
        {investors.map((inv) => (
          <div key={inv.id} className="card">
            <div className="flex justify-between items-start">
              <div>
                <p className="font-semibold">{inv.fullName}</p>
                <p className="text-sm text-slate-500">{inv.email}</p>
                <p className="text-xs text-slate-500">
                  {inv.documentType} {inv.documentNumber} · {inv.phone ?? 'sem telefone'}
                </p>
              </div>
              <span className="badge bg-slate-100 text-slate-700">{inv.verificationStatus}</span>
            </div>
            <div className="flex gap-3 mt-2 text-sm">
              <a className="text-brand-700 font-medium" href={fileUrl(inv.documentFilePath)} target="_blank" rel="noreferrer">
                Ver documento
              </a>
              <a className="text-brand-700 font-medium" href={fileUrl(inv.verificationVideoPath)} target="_blank" rel="noreferrer">
                Ver vídeo
              </a>
            </div>
            {inv.verificationStatus === 'PENDING' && (
              <div className="mt-3 flex gap-2 items-center">
                <input
                  className="input"
                  placeholder="Notas (opcional)"
                  value={notes[inv.id] ?? ''}
                  onChange={(e) => setNotes({ ...notes, [inv.id]: e.target.value })}
                />
                <button className="btn-primary" onClick={() => decide(inv.id, true)}>
                  Aprovar
                </button>
                <button className="btn-danger" onClick={() => decide(inv.id, false)}>
                  Rejeitar
                </button>
              </div>
            )}
          </div>
        ))}
        {investors.length === 0 && <p className="text-sm text-slate-500">Sem investidores para mostrar.</p>}
      </div>
    </div>
  );
}
