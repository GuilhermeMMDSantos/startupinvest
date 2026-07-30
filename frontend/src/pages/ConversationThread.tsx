import { FormEvent, useEffect, useRef, useState } from 'react';
import { useParams } from 'react-router-dom';
import { api } from '../lib/api';
import type { MessageDto } from '../types';
import { useAuth } from '../context/AuthContext';

export default function ConversationThread() {
  const { id } = useParams();
  const { user } = useAuth();
  const [messages, setMessages] = useState<MessageDto[]>([]);
  const [content, setContent] = useState('');
  const bottomRef = useRef<HTMLDivElement>(null);

  function load() {
    api.get(`/conversations/${id}/messages`).then(({ data }) => setMessages(data));
  }

  useEffect(() => {
    load();
    const interval = setInterval(load, 8000);
    return () => clearInterval(interval);
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [id]);

  useEffect(() => {
    bottomRef.current?.scrollIntoView({ behavior: 'smooth' });
  }, [messages.length]);

  async function send(e: FormEvent) {
    e.preventDefault();
    if (!content.trim()) return;
    await api.post(`/conversations/${id}/messages`, { content });
    setContent('');
    load();
  }

  return (
    <div className="max-w-2xl mx-auto px-4 py-10 flex flex-col h-[75vh]">
      <h1 className="text-xl font-bold mb-4">Conversa</h1>
      <div className="flex-1 overflow-y-auto card space-y-2 mb-3">
        {messages.map((m) => (
          <div key={m.id} className={`max-w-[75%] rounded-lg px-3 py-2 text-sm ${m.senderId === user?.userId ? 'bg-brand-600 text-white ml-auto' : 'bg-slate-100'}`}>
            {m.content}
          </div>
        ))}
        <div ref={bottomRef} />
      </div>
      <form onSubmit={send} className="flex gap-2">
        <input className="input" value={content} onChange={(e) => setContent(e.target.value)} placeholder="Escreva uma mensagem..." />
        <button className="btn-primary">Enviar</button>
      </form>
    </div>
  );
}
