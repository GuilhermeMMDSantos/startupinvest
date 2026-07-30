import { Link } from 'react-router-dom';

export default function RegisterChoice() {
  return (
    <div className="max-w-2xl mx-auto mt-16 px-4">
      <h1 className="text-2xl font-bold mb-6 text-center">Como quer registar-se?</h1>
      <div className="grid sm:grid-cols-2 gap-4">
        <Link to="/register/investor" className="card hover:border-brand-400 transition-colors">
          <h2 className="font-semibold text-lg mb-1">Sou Investidor</h2>
          <p className="text-sm text-slate-600">
            Registe-se com email, BI/passaporte e um vídeo de confirmação para investir em startups angolanas.
          </p>
        </Link>
        <Link to="/register/startup" className="card hover:border-brand-400 transition-colors">
          <h2 className="font-semibold text-lg mb-1">Sou uma Startup</h2>
          <p className="text-sm text-slate-600">
            Registe a sua startup com nome, NIF e pitch deck para abrir uma rodada de investimento.
          </p>
        </Link>
      </div>
    </div>
  );
}
