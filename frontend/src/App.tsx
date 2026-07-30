import { Route, Routes } from 'react-router-dom';
import Navbar from './components/Navbar';
import ProtectedRoute from './components/ProtectedRoute';

import Landing from './pages/Landing';
import Login from './pages/Login';
import RegisterChoice from './pages/RegisterChoice';
import RegisterInvestor from './pages/RegisterInvestor';
import RegisterStartup from './pages/RegisterStartup';
import RoundsList from './pages/RoundsList';
import RoundDetail from './pages/RoundDetail';
import Messages from './pages/Messages';
import ConversationThread from './pages/ConversationThread';
import Notifications from './pages/Notifications';

import InvestorDashboard from './pages/investor/InvestorDashboard';
import InvestmentDetail from './pages/investor/InvestmentDetail';

import StartupDashboard from './pages/startup/StartupDashboard';
import StartupProfile from './pages/startup/StartupProfile';
import CreateRound from './pages/startup/CreateRound';
import RoundAssessment from './pages/startup/RoundAssessment';
import RoundManage from './pages/startup/RoundManage';
import StartupInvestmentDetail from './pages/startup/StartupInvestmentDetail';

import AdminDashboard from './pages/admin/AdminDashboard';
import AdminInvestors from './pages/admin/AdminInvestors';
import AdminUsers from './pages/admin/AdminUsers';
import AdminStartups from './pages/admin/AdminStartups';
import AdminOversight from './pages/admin/AdminOversight';

export default function App() {
  return (
    <div className="min-h-screen flex flex-col">
      <Navbar />
      <main className="flex-1">
        <Routes>
          <Route path="/" element={<Landing />} />
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<RegisterChoice />} />
          <Route path="/register/investor" element={<RegisterInvestor />} />
          <Route path="/register/startup" element={<RegisterStartup />} />
          <Route path="/rounds" element={<RoundsList />} />
          <Route path="/rounds/:id" element={<RoundDetail />} />

          <Route element={<ProtectedRoute />}>
            <Route path="/notifications" element={<Notifications />} />
          </Route>

          <Route element={<ProtectedRoute roles={['INVESTOR']} />}>
            <Route path="/investor" element={<InvestorDashboard />} />
            <Route path="/investor/investments/:id" element={<InvestmentDetail />} />
            <Route path="/investor/messages" element={<Messages />} />
            <Route path="/investor/messages/:id" element={<ConversationThread />} />
          </Route>

          <Route element={<ProtectedRoute roles={['STARTUP_OWNER']} />}>
            <Route path="/startup" element={<StartupDashboard />} />
            <Route path="/startup/profile" element={<StartupProfile />} />
            <Route path="/startup/rounds/new" element={<CreateRound />} />
            <Route path="/startup/rounds/:roundId/assessment" element={<RoundAssessment />} />
            <Route path="/startup/rounds/:roundId" element={<RoundManage />} />
            <Route path="/startup/rounds/:roundId/investments/:investmentId" element={<StartupInvestmentDetail />} />
            <Route path="/startup/messages" element={<Messages />} />
            <Route path="/startup/messages/:id" element={<ConversationThread />} />
          </Route>

          <Route element={<ProtectedRoute roles={['ADMIN']} />}>
            <Route path="/admin" element={<AdminDashboard />} />
            <Route path="/admin/users" element={<AdminUsers />} />
            <Route path="/admin/investors" element={<AdminInvestors />} />
            <Route path="/admin/startups" element={<AdminStartups />} />
            <Route path="/admin/oversight" element={<AdminOversight />} />
          </Route>

          <Route path="*" element={<Landing />} />
        </Routes>
      </main>
    </div>
  );
}
