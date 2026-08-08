export interface StartupDto {
  id: number;
  name: string;
  nif: string;
  sector: string | null;
  businessModel: string | null;
  shortDescription: string | null;
  website: string | null;
  logoPath: string | null;
  status: string;
  paypalPayoutEmail: string | null;
}

export interface TeamMemberDto {
  id: number;
  fullName: string;
  roleTitle: string;
  experienceYears: number;
  management: boolean;
  technical: boolean;
  linkedinUrl: string | null;
}

export interface ScoringSummary {
  growthPotentialScore: number;
  seriesBLikelihood: 'BAIXO' | 'MEDIO' | 'ALTO';
  strengths: Record<string, number>;
  weaknesses: Record<string, number>;
}

export interface RoundDto {
  id: number;
  startupId: number;
  startupName: string;
  startupSector: string | null;
  targetAmount: number;
  equityOfferedPct: number;
  maxInvestors: number;
  minTicket: number;
  amountRaised: number;
  contractType: 'EQUITY_INVESTMENT' | 'CONVERTIBLE_NOTE';
  pitchVideoPath: string;
  status: string;
  openedAt: string | null;
  scoring: ScoringSummary | null;
}

export interface InvestmentDto {
  id: number;
  roundId: number;
  startupName: string;
  investorId: number;
  investorName: string;
  amount: number;
  equityPctAllocated: number;
  status: string;
  createdAt: string;
}

export interface ContractDto {
  id: number;
  investmentId: number;
  contractType: string;
  content: string;
  status: string;
  createdAt: string;
}

export interface InvestorProfileDto {
  id: number;
  userId: number;
  email: string;
  fullName: string;
  documentType: string;
  documentNumber: string;
  documentFilePath: string;
  verificationVideoPath: string;
  phone: string | null;
  verificationStatus: string;
}

export interface NotificationDto {
  id: number;
  type: string;
  title: string;
  body: string | null;
  readAt: string | null;
  createdAt: string;
}

export interface ConversationDto {
  id: number;
  roundId: number;
  startupName: string;
  investorName: string;
  createdAt: string;
}

export interface MessageDto {
  id: number;
  senderId: number;
  senderName: string;
  content: string;
  sentAt: string;
}

export interface PaymentDto {
  id: number;
  investmentId: number | null;
  type: string;
  provider: string;
  providerOrderId: string | null;
  amount: number;
  currency: string;
  status: string;
  createdAt: string;
}

export interface AdminStatsDto {
  totalUsers: number;
  totalInvestors: number;
  pendingInvestorVerifications: number;
  totalStartups: number;
  pendingStartupApprovals: number;
  openRounds: number;
  closedSuccessRounds: number;
  totalRaised: number;
  totalInvestments: number;
  pendingContracts: number;
}

export interface UserSummaryDto {
  id: number;
  email: string;
  role: 'ADMIN' | 'INVESTOR' | 'STARTUP_OWNER';
  status: 'PENDING_VERIFICATION' | 'ACTIVE' | 'SUSPENDED' | 'REJECTED';
  createdAt: string;
  updatedAt: string;
}
