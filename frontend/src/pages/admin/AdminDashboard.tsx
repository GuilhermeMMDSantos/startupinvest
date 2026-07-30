import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { api } from '../../lib/api';
import type { AdminStatsDto } from '../../types';

export default function AdminDashboard() {
  const [stats, setStats] = useState<AdminStatsDto | null>(null);

  useEffect(() => {
    api.get('/admin/stats').then(({ data }) => setStats(data));
  }, []);

  const tiles = stats
    ? [
        { label: 'Utilizadores', value: stats.totalUsers },
        { label: 'Investidores', value: stats.totalInvestors },
        { label: 'Verificações pendentes', value: stats.pendingInvestorVerifications, alert: stats.pendingInvestorVerifications > 0 },
        { label: 'Startups', value: stats.totalStartups },
        { label: 'Aprovações pendentes', value: stats.pendingStartupApprovals, alert: stats.pendingStartupApprovals > 0 },
        { label: 'Rodadas abertas', value: stats.openRounds },
        { label: 'Rodadas concluídas', value: stats.closedSuccessRounds },
        { label: 'Total angariado (USD)', value: stats.totalRaised.toLocaleString() },
        { label: 'Investimentos', value: stats.totalInvestments },
        { label: 'Contratos pendentes', value: stats.pendingContracts, alert: stats.pendingContracts > 0 },
      ]
    : [];

  return (
    <div className="max-w-5xl mx-auto px-4 py-10 space-y-6">
      <h1 className="text-2xl font-bold">Painel do Administrador</h1>

      <div className="grid sm:grid-cols-3 lg:grid-cols-5 gap-4">
        {tiles.map((t) => (
          <div key={t.label} className={`card ${t.alert ? 'border-amber-400 bg-amber-50' : ''}`}>
            <p className="text-2xl font-bold">{t.value}</p>
            <p className="text-xs text-slate-500">{t.label}</p>
          </div>
        ))}
      </div>

      <div className="grid sm:grid-cols-3 gap-4">
        <Link to="/admin/users" className="card hover:border-brand-400">
          <p className="font-semibold">Gerir utilizadores</p>
        </Link>
        <Link to="/admin/investors" className="card hover:border-brand-400">
          <p className="font-semibold">Verificar investidores</p>
        </Link>
        <Link to="/admin/startups" className="card hover:border-brand-400">
          <p className="font-semibold">Aprovar startups</p>
        </Link>
        <Link to="/admin/oversight" className="card hover:border-brand-400">
          <p className="font-semibold">Rodadas, investimentos, pagamentos e contratos</p>
        </Link>
      </div>
    </div>
  );
}
