import { FormEvent, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { api, apiErrorMessage } from '../lib/api';
import { useAuth } from '../context/AuthContext';

export default function RegisterStartup() {
  const navigate = useNavigate();
  const { loginWithToken } = useAuth();
  const [form, setForm] = useState({
    email: '',
    password: '',
    startupName: '',
    nif: '',
    sector: '',
    businessModel: 'B2C',
    shortDescription: '',
    website: '',
  });
  const [pitchDeck, setPitchDeck] = useState<File | null>(null);
  const [logo, setLogo] = useState<File | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  function update(key: string, value: string) {
    setForm((f) => ({ ...f, [key]: value }));
  }

  async function onSubmit(e: FormEvent) {
    e.preventDefault();
    setError(null);
    if (!pitchDeck) {
      setError('Anexe o pitch deck da startup');
      return;
    }
    setLoading(true);
    try {
      const fd = new FormData();
      Object.entries(form).forEach(([k, v]) => fd.append(k, v));
      fd.append('pitchDeck', pitchDeck);
      if (logo) fd.append('logo', logo);
      const { data } = await api.post('/auth/register/startup', fd, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });
      loginWithToken(data.accessToken, { userId: data.userId, email: data.email, role: data.role, status: data.status });
      navigate('/startup');
    } catch (err) {
      setError(apiErrorMessage(err));
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="max-w-lg mx-auto my-12 px-4">
      <div className="card">
        <h1 className="text-xl font-bold mb-1">Registo de Startup</h1>
        <p className="text-sm text-slate-600 mb-4">
          A sua startup ficará pendente de aprovação pelo administrador antes de poder abrir uma rodada.
        </p>
        {error && <p className="text-red-600 text-sm mb-3">{error}</p>}
        <form onSubmit={onSubmit} className="space-y-4">
          <div>
            <label className="label">Nome da startup</label>
            <input className="input" value={form.startupName} onChange={(e) => update('startupName', e.target.value)} required />
          </div>
          <div>
            <label className="label">NIF</label>
            <input className="input" value={form.nif} onChange={(e) => update('nif', e.target.value)} required />
          </div>
          <div className="grid grid-cols-2 gap-3">
            <div>
              <label className="label">Email</label>
              <input className="input" type="email" value={form.email} onChange={(e) => update('email', e.target.value)} required />
            </div>
            <div>
              <label className="label">Palavra-passe</label>
              <input
                className="input"
                type="password"
                value={form.password}
                onChange={(e) => update('password', e.target.value)}
                required
                minLength={8}
              />
            </div>
          </div>
          <div className="grid grid-cols-2 gap-3">
            <div>
              <label className="label">Setor</label>
              <input className="input" value={form.sector} onChange={(e) => update('sector', e.target.value)} />
            </div>
            <div>
              <label className="label">Modelo de negócio</label>
              <select className="input" value={form.businessModel} onChange={(e) => update('businessModel', e.target.value)}>
                <option value="B2C">B2C</option>
                <option value="B2B">B2B</option>
                <option value="B2B2C">B2B2C</option>
              </select>
            </div>
          </div>
          <div>
            <label className="label">Descrição breve</label>
            <textarea
              className="input"
              rows={3}
              value={form.shortDescription}
              onChange={(e) => update('shortDescription', e.target.value)}
            />
          </div>
          <div>
            <label className="label">Website</label>
            <input className="input" value={form.website} onChange={(e) => update('website', e.target.value)} />
          </div>
          <div>
            <label className="label">Pitch deck — PDF ou PPT</label>
            <input
              className="input"
              type="file"
              accept=".pdf,.ppt,.pptx"
              onChange={(e) => setPitchDeck(e.target.files?.[0] ?? null)}
              required
            />
          </div>
          <div>
            <label className="label">Logótipo (opcional)</label>
            <input className="input" type="file" accept=".png,.jpg,.jpeg" onChange={(e) => setLogo(e.target.files?.[0] ?? null)} />
          </div>
          <button className="btn-primary w-full" disabled={loading}>
            {loading ? 'A enviar...' : 'Registar startup'}
          </button>
        </form>
      </div>
    </div>
  );
}
