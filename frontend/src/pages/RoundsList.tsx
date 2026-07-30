import { useEffect, useState } from 'react';
import { api } from '../lib/api';
import type { RoundDto } from '../types';
import RoundCard from '../components/RoundCard';

export default function RoundsList() {
  const [rounds, setRounds] = useState<RoundDto[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    api
      .get('/rounds')
      .then(({ data }) => setRounds(data))
      .finally(() => setLoading(false));
  }, []);

  return (
    <div className="max-w-5xl mx-auto px-4 py-10">
      <h1 className="text-2xl font-bold mb-6">Rodadas abertas</h1>
      {loading && <p className="text-slate-500">A carregar...</p>}
      {!loading && rounds.length === 0 && <p className="text-slate-500">Não há rodadas abertas neste momento.</p>}
      <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        {rounds.map((r) => (
          <RoundCard key={r.id} round={r} />
        ))}
      </div>
    </div>
  );
}
