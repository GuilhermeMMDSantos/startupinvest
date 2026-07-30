import { FormEvent, useEffect, useState } from 'react';
import { api, apiErrorMessage } from '../../lib/api';
import type { StartupDto, TeamMemberDto } from '../../types';

export default function StartupProfile() {
  const [startup, setStartup] = useState<StartupDto | null>(null);
  const [team, setTeam] = useState<TeamMemberDto[]>([]);
  const [form, setForm] = useState({ sector: '', businessModel: 'B2C', shortDescription: '', website: '', paypalPayoutEmail: '' });
  const [member, setMember] = useState({ fullName: '', roleTitle: '', experienceYears: '0', management: false, technical: false, linkedinUrl: '' });
  const [error, setError] = useState<string | null>(null);
  const [saved, setSaved] = useState(false);

  function load() {
    api.get('/startups/me').then(({ data }) => {
      setStartup(data);
      setForm({
        sector: data.sector ?? '',
        businessModel: data.businessModel ?? 'B2C',
        shortDescription: data.shortDescription ?? '',
        website: data.website ?? '',
        paypalPayoutEmail: data.paypalPayoutEmail ?? '',
      });
    });
    api.get('/startups/me/team').then(({ data }) => setTeam(data));
  }

  useEffect(load, []);

  async function saveProfile(e: FormEvent) {
    e.preventDefault();
    setError(null);
    setSaved(false);
    try {
      await api.put('/startups/me', form);
      setSaved(true);
      load();
    } catch (err) {
      setError(apiErrorMessage(err));
    }
  }

  async function addMember(e: FormEvent) {
    e.preventDefault();
    setError(null);
    try {
      await api.post('/startups/me/team', { ...member, experienceYears: Number(member.experienceYears) });
      setMember({ fullName: '', roleTitle: '', experienceYears: '0', management: false, technical: false, linkedinUrl: '' });
      load();
    } catch (err) {
      setError(apiErrorMessage(err));
    }
  }

  async function removeMember(id: number) {
    await api.delete(`/startups/me/team/${id}`);
    load();
  }

  if (!startup) return <div className="max-w-3xl mx-auto px-4 py-10">A carregar...</div>;

  return (
    <div className="max-w-3xl mx-auto px-4 py-10 space-y-6">
      <h1 className="text-2xl font-bold">Perfil da startup</h1>
      {error && <p className="text-red-600 text-sm">{error}</p>}
      {saved && <p className="text-green-600 text-sm">Perfil atualizado.</p>}

      <form onSubmit={saveProfile} className="card space-y-4">
        <p className="font-semibold">{startup.name} · NIF {startup.nif}</p>
        <div className="grid grid-cols-2 gap-3">
          <div>
            <label className="label">Setor</label>
            <input className="input" value={form.sector} onChange={(e) => setForm({ ...form, sector: e.target.value })} />
          </div>
          <div>
            <label className="label">Modelo de negócio</label>
            <select className="input" value={form.businessModel} onChange={(e) => setForm({ ...form, businessModel: e.target.value })}>
              <option value="B2C">B2C</option>
              <option value="B2B">B2B</option>
              <option value="B2B2C">B2B2C</option>
            </select>
          </div>
        </div>
        <div>
          <label className="label">Descrição</label>
          <textarea className="input" rows={3} value={form.shortDescription} onChange={(e) => setForm({ ...form, shortDescription: e.target.value })} />
        </div>
        <div>
          <label className="label">Website</label>
          <input className="input" value={form.website} onChange={(e) => setForm({ ...form, website: e.target.value })} />
        </div>
        <div>
          <label className="label">Email PayPal para recebimento dos fundos</label>
          <input
            className="input"
            type="email"
            placeholder="sb-xxxxx@business.example.com"
            value={form.paypalPayoutEmail}
            onChange={(e) => setForm({ ...form, paypalPayoutEmail: e.target.value })}
          />
          <p className="text-xs text-slate-500 mt-1">Necessário antes de poder abrir uma rodada.</p>
        </div>
        <button className="btn-primary">Guardar</button>
      </form>

      <div className="card">
        <h2 className="font-semibold mb-3">Equipa</h2>
        <div className="space-y-2 mb-4">
          {team.map((m) => (
            <div key={m.id} className="flex justify-between items-center border-b border-slate-100 pb-2">
              <div>
                <p className="text-sm font-medium">
                  {m.fullName} — {m.roleTitle}
                </p>
                <p className="text-xs text-slate-500">
                  {m.experienceYears} anos de experiência {m.management && '· Gestão'} {m.technical && '· Técnico'}
                </p>
              </div>
              <button className="text-xs text-red-600" onClick={() => removeMember(m.id)}>
                Remover
              </button>
            </div>
          ))}
          {team.length === 0 && <p className="text-sm text-slate-500">Sem membros adicionados.</p>}
        </div>
        <form onSubmit={addMember} className="grid grid-cols-2 gap-3">
          <input className="input" placeholder="Nome completo" value={member.fullName} onChange={(e) => setMember({ ...member, fullName: e.target.value })} required />
          <input className="input" placeholder="Cargo" value={member.roleTitle} onChange={(e) => setMember({ ...member, roleTitle: e.target.value })} required />
          <input
            className="input"
            type="number"
            placeholder="Anos de experiência"
            value={member.experienceYears}
            onChange={(e) => setMember({ ...member, experienceYears: e.target.value })}
          />
          <input className="input" placeholder="LinkedIn (opcional)" value={member.linkedinUrl} onChange={(e) => setMember({ ...member, linkedinUrl: e.target.value })} />
          <label className="text-sm flex items-center gap-2">
            <input type="checkbox" checked={member.management} onChange={(e) => setMember({ ...member, management: e.target.checked })} /> Experiência em gestão
          </label>
          <label className="text-sm flex items-center gap-2">
            <input type="checkbox" checked={member.technical} onChange={(e) => setMember({ ...member, technical: e.target.checked })} /> Perfil técnico
          </label>
          <button className="btn-secondary col-span-2">Adicionar membro</button>
        </form>
      </div>
    </div>
  );
}
