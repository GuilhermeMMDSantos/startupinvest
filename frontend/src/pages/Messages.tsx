import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { api } from '../lib/api';
import type { ConversationDto } from '../types';
import { useAuth } from '../context/AuthContext';

export default function Messages() {
  const { user } = useAuth();
  const [conversations, setConversations] = useState<ConversationDto[]>([]);
  const base = user?.role === 'STARTUP_OWNER' ? '/startup' : '/investor';

  useEffect(() => {
    api.get('/conversations').then(({ data }) => setConversations(data));
  }, []);

  return (
    <div className="max-w-3xl mx-auto px-4 py-10">
      <h1 className="text-2xl font-bold mb-6">Mensagens</h1>
      <div className="space-y-2">
        {conversations.length === 0 && <p className="text-sm text-slate-500">Ainda não tem conversas.</p>}
        {conversations.map((c) => (
          <Link key={c.id} to={`${base}/messages/${c.id}`} className="card flex justify-between items-center hover:border-brand-400">
            <div>
              <p className="font-medium">{c.startupName}</p>
              <p className="text-xs text-slate-500">com {c.investorName}</p>
            </div>
          </Link>
        ))}
      </div>
    </div>
  );
}
