import { FormEvent, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { api } from '../lib/api';
import { apiErrorMessage } from '../lib/api';
import { useAuth } from '../context/AuthContext';

export default function RegisterInvestor() {
  const navigate = useNavigate();
  const { loginWithToken } = useAuth();
  const [form, setForm] = useState({
    email: '',
    password: '',
    fullName: '',
    documentType: 'BI',
    documentNumber: '',
    phone: '',
  });
  const [documentFile, setDocumentFile] = useState<File | null>(null);
  const [verificationVideo, setVerificationVideo] = useState<File | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  function update(key: string, value: string) {
    setForm((f) => ({ ...f, [key]: value }));
  }

  async function onSubmit(e: FormEvent) {
    e.preventDefault();
    setError(null);
    if (!documentFile || !verificationVideo) {
      setError('Anexe o documento de identificação e o vídeo de confirmação');
      return;
    }
    setLoading(true);
    try {
      const fd = new FormData();
      Object.entries(form).forEach(([k, v]) => fd.append(k, v));
      fd.append('documentFile', documentFile);
      fd.append('verificationVideo', verificationVideo);
      const { data } = await api.post('/auth/register/investor', fd, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });
      loginWithToken(data.accessToken, { userId: data.userId, email: data.email, role: data.role, status: data.status });
      navigate('/investor');
    } catch (err) {
      setError(apiErrorMessage(err));
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="max-w-lg mx-auto my-12 px-4">
      <div className="card">
        <h1 className="text-xl font-bold mb-1">Registo de Investidor</h1>
        <p className="text-sm text-slate-600 mb-4">
          A sua conta ficará pendente de verificação pelo administrador até validarmos o seu documento e vídeo.
        </p>
        {error && <p className="text-red-600 text-sm mb-3">{error}</p>}
        <form onSubmit={onSubmit} className="space-y-4">
          <div>
            <label className="label">Nome completo</label>
            <input className="input" value={form.fullName} onChange={(e) => update('fullName', e.target.value)} required />
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
              <label className="label">Tipo de documento</label>
              <select className="input" value={form.documentType} onChange={(e) => update('documentType', e.target.value)}>
                <option value="BI">Bilhete de Identidade</option>
                <option value="PASSPORT">Passaporte</option>
              </select>
            </div>
            <div>
              <label className="label">Número do documento</label>
              <input className="input" value={form.documentNumber} onChange={(e) => update('documentNumber', e.target.value)} required />
            </div>
          </div>
          <div>
            <label className="label">Telefone</label>
            <input className="input" value={form.phone} onChange={(e) => update('phone', e.target.value)} />
          </div>
          <div>
            <label className="label">Documento (BI/Passaporte) - PDF, PNG ou JPG</label>
            <input
              className="input"
              type="file"
              accept=".pdf,.png,.jpg,.jpeg"
              onChange={(e) => setDocumentFile(e.target.files?.[0] ?? null)}
              required
            />
          </div>
          <div>
            <label className="label">Vídeo de confirmação de identidade</label>
            <input
              className="input"
              type="file"
              accept=".mp4,.mov,.webm"
              onChange={(e) => setVerificationVideo(e.target.files?.[0] ?? null)}
              required
            />
          </div>
          <button className="btn-primary w-full" disabled={loading}>
            {loading ? 'A enviar...' : 'Criar conta de investidor'}
          </button>
        </form>
      </div>
    </div>
  );
}
