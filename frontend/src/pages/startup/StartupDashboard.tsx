import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { api } from '../../lib/api';
import type { StartupDto, RoundDto } from '../../types';

const STATUS_LABEL: Record<string, string> = {
  PENDING_APPROVAL: 'Pendente de aprovação pelo administrador',
  APPROVED: 'Aprovada',
  REJECTED: 'Rejeitada',
  SUSPENDED: 'Suspensa',
};

export default function StartupDashboard() {
  const [startup, setStartup] = useState<StartupDto | null>(null);
  const [rounds, setRounds] = useState<RoundDto[]>([]);

  useEffect(() => {
    api.get('/startups/me').then(({ data }) => setStartup(data));
    api.get('/rounds/mine').then(({ data }) => setRounds(data));
  }, []);

  const ongoing = rounds.find((r) => ['DRAFT', 'OPEN', 'CONTRACTS_PENDING', 'FUNDED'].includes(r.status));

  return (
    <div className="max-w-4xl mx-auto px-4 py-10 space-y-6">
      <h1 className="text-2xl font-bold">Painel da Startup</h1>

      {startup && (
        <div className="card flex justify-between items-center">
          <div>
            <p className="font-semibold">{startup.name}</p>
            <p className="text-sm text-slate-500">{STATUS_LABEL[startup.status]}</p>
          </div>
          <Link to="/startup/profile" className="btn-secondary">
            Editar perfil
          </Link>
        </div>
      )}

      <div className="grid sm:grid-cols-3 gap-4">
        <Link to="/startup/messages" className="card hover:border-brand-400">
          <p className="font-semibold">Mensagens</p>
          <p className="text-sm text-slate-500">Converse com investidores</p>
        </Link>
        <Link to="/notifications" className="card hover:border-brand-400">
          <p className="font-semibold">Notificações</p>
          <p className="text-sm text-slate-500">Atualizações da plataforma</p>
        </Link>
        {startup?.status === 'APPROVED' && !ongoing && (
          <Link to="/startup/rounds/new" className="card hover:border-brand-400 bg-brand-50 border-brand-200">
            <p className="font-semibold text-brand-800">+ Abrir rodada</p>
            <p className="text-sm text-brand-700">Comece uma nova rodada de investimento</p>
          </Link>
        )}
      </div>

      <div>
        <h2 className="font-semibold mb-3">Rodadas</h2>
        <div className="space-y-2">
          {rounds.length === 0 && <p className="text-sm text-slate-500">Ainda não abriu nenhuma rodada.</p>}
          {rounds.map((r) => (
            <Link key={r.id} to={`/startup/rounds/${r.id}`} className="card flex justify-between items-center hover:border-brand-400">
              <div>
                <p className="font-medium">Meta {r.targetAmount.toLocaleString()} USD</p>
                <p className="text-xs text-slate-500">
                  {r.amountRaised.toLocaleString()} USD angariados · {r.equityOfferedPct}% oferecido
                </p>
              </div>
              <span className="badge bg-slate-100 text-slate-700">{r.status}</span>
            </Link>
          ))}
        </div>
      </div>
    </div>
  );
}
