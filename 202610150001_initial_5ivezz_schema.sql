-- 5ivezz initial backend schema for Supabase/PostgreSQL.
-- Apply via Supabase SQL Editor or Supabase CLI after reviewing for your business rules.
create extension if not exists pgcrypto;

create type public.app_role as enum ('player', 'manager', 'organizer', 'admin');
create type public.tournament_status as enum ('draft', 'published', 'in_progress', 'completed', 'cancelled');
create type public.registration_status as enum ('pending', 'approved', 'rejected', 'withdrawn');
create type public.wallet_transaction_status as enum ('pending', 'completed', 'failed', 'reversed');
create type public.wallet_transaction_type as enum ('top_up', 'payment', 'refund', 'payout', 'adjustment');

create table public.profiles (
  id uuid primary key references auth.users(id) on delete cascade,
  full_name text not null default '',
  role public.app_role not null default 'player',
  phone text,
  avatar_url text,
  bio text,
  home_state text,
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now()
);

create function public.handle_new_user()
returns trigger language plpgsql security definer set search_path = ''
as $$
declare requested_role text;
begin
  requested_role := coalesce(new.raw_user_meta_data ->> 'role', 'player');
  -- Never allow public sign-up to grant admin privileges.
  if requested_role not in ('player', 'manager', 'organizer') then
    requested_role := 'player';
  end if;
  insert into public.profiles (id, full_name, role)
  values (new.id, coalesce(new.raw_user_meta_data ->> 'full_name', ''), requested_role::public.app_role);
  insert into public.wallet_accounts (user_id) values (new.id);
  return new;
end;
$$;

create table public.teams (
  id uuid primary key default gen_random_uuid(),
  name text not null,
  short_name text,
  logo_url text,
  home_state text,
  created_by uuid not null references public.profiles(id),
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now()
);

create table public.team_members (
  team_id uuid not null references public.teams(id) on delete cascade,
  user_id uuid not null references public.profiles(id) on delete cascade,
  member_role text not null default 'player' check (member_role in ('player', 'captain', 'manager')),
  status text not null default 'active' check (status in ('invited', 'active', 'left')),
  joined_at timestamptz not null default now(),
  primary key (team_id, user_id)
);

create table public.tournaments (
  id uuid primary key default gen_random_uuid(),
  organizer_id uuid not null references public.profiles(id),
  name text not null,
  description text,
  location text,
  start_date date,
  end_date date,
  format text,
  max_teams integer check (max_teams is null or max_teams > 0),
  registration_fee_kobo bigint not null default 0 check (registration_fee_kobo >= 0),
  status public.tournament_status not null default 'draft',
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now(),
  check (end_date is null or start_date is null or end_date >= start_date)
);

create table public.tournament_registrations (
  id uuid primary key default gen_random_uuid(),
  tournament_id uuid not null references public.tournaments(id) on delete cascade,
  team_id uuid not null references public.teams(id) on delete cascade,
  registered_by uuid not null references public.profiles(id),
  status public.registration_status not null default 'pending',
  created_at timestamptz not null default now(),
  unique (tournament_id, team_id)
);

create table public.matches (
  id uuid primary key default gen_random_uuid(),
  tournament_id uuid not null references public.tournaments(id) on delete cascade,
  home_team_id uuid references public.teams(id),
  away_team_id uuid references public.teams(id),
  kickoff_at timestamptz,
  venue text,
  home_score integer not null default 0 check (home_score >= 0),
  away_score integer not null default 0 check (away_score >= 0),
  status text not null default 'scheduled' check (status in ('scheduled', 'live', 'completed', 'postponed', 'cancelled')),
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now(),
  check (home_team_id is null or away_team_id is null or home_team_id <> away_team_id)
);

create table public.match_events (
  id uuid primary key default gen_random_uuid(),
  match_id uuid not null references public.matches(id) on delete cascade,
  team_id uuid references public.teams(id),
  player_id uuid references public.profiles(id),
  event_type text not null check (event_type in ('goal', 'assist', 'yellow_card', 'red_card', 'own_goal', 'substitution', 'other')),
  minute integer check (minute is null or minute between 0 and 150),
  notes text,
  recorded_by uuid references public.profiles(id),
  created_at timestamptz not null default now()
);

-- Wallet accounts and ledger are scaffolding only. Never let clients directly set balances.
create table public.wallet_accounts (
  id uuid primary key default gen_random_uuid(),
  user_id uuid not null unique references public.profiles(id) on delete cascade,
  currency char(3) not null default 'NGN',
  balance_kobo bigint not null default 0 check (balance_kobo >= 0),
  status text not null default 'active' check (status in ('active', 'restricted', 'closed')),
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now()
);

create table public.wallet_transactions (
  id uuid primary key default gen_random_uuid(),
  wallet_account_id uuid not null references public.wallet_accounts(id),
  transaction_type public.wallet_transaction_type not null,
  status public.wallet_transaction_status not null default 'pending',
  amount_kobo bigint not null check (amount_kobo > 0),
  currency char(3) not null default 'NGN',
  reference text unique,
  provider text,
  provider_reference text,
  description text,
  metadata jsonb not null default '{}'::jsonb,
  created_at timestamptz not null default now(),
  completed_at timestamptz
);

create index tournaments_status_start_idx on public.tournaments(status, start_date);
create index tournaments_organizer_idx on public.tournaments(organizer_id);
create index registrations_tournament_idx on public.tournament_registrations(tournament_id, status);
create index team_members_user_idx on public.team_members(user_id);
create index matches_tournament_idx on public.matches(tournament_id, kickoff_at);
create index match_events_match_idx on public.match_events(match_id, created_at);
create index wallet_transactions_account_idx on public.wallet_transactions(wallet_account_id, created_at desc);

-- Trigger requires wallet_accounts to exist before it can create an account.
create trigger on_auth_user_created
after insert on auth.users
for each row execute procedure public.handle_new_user();

alter table public.profiles enable row level security;
alter table public.teams enable row level security;
alter table public.team_members enable row level security;
alter table public.tournaments enable row level security;
alter table public.tournament_registrations enable row level security;
alter table public.matches enable row level security;
alter table public.match_events enable row level security;
alter table public.wallet_accounts enable row level security;
alter table public.wallet_transactions enable row level security;

-- Profiles: users can read public football identity fields and update only their own profile.
create policy "profiles readable to authenticated users" on public.profiles
for select to authenticated using (true);
create policy "users update own profile" on public.profiles
for update to authenticated using (auth.uid() = id) with check (auth.uid() = id);

-- Teams: signed-in users can view teams; only creator/manager can edit.
create policy "teams readable to authenticated users" on public.teams
for select to authenticated using (true);
create policy "authenticated users create teams" on public.teams
for insert to authenticated with check (created_by = auth.uid());
create policy "team creator updates team" on public.teams
for update to authenticated using (created_by = auth.uid()) with check (created_by = auth.uid());
create policy "team creator deletes team" on public.teams
for delete to authenticated using (created_by = auth.uid());

create policy "team membership readable to authenticated users" on public.team_members
for select to authenticated using (true);
create policy "users join own membership" on public.team_members
for insert to authenticated with check (user_id = auth.uid());
create policy "users leave own membership" on public.team_members
for delete to authenticated using (user_id = auth.uid());

-- Tournament discovery is public for published tournaments; organizers see/manage their own.
create policy "published tournaments are public" on public.tournaments
for select to anon, authenticated using (status = 'published' or organizer_id = auth.uid());
create policy "organizers create own tournaments" on public.tournaments
for insert to authenticated with check (
  organizer_id = auth.uid()
  and exists (select 1 from public.profiles p where p.id = auth.uid() and p.role in ('organizer', 'admin'))
);
create policy "organizers update own tournaments" on public.tournaments
for update to authenticated using (
  organizer_id = auth.uid()
  or exists (select 1 from public.profiles p where p.id = auth.uid() and p.role = 'admin')
) with check (
  organizer_id = auth.uid()
  or exists (select 1 from public.profiles p where p.id = auth.uid() and p.role = 'admin')
);
create policy "organizers delete own drafts" on public.tournaments
for delete to authenticated using (
  (organizer_id = auth.uid() and status = 'draft')
  or exists (select 1 from public.profiles p where p.id = auth.uid() and p.role = 'admin')
);

create policy "registrations visible to involved users" on public.tournament_registrations
for select to authenticated using (
  registered_by = auth.uid()
  or exists (select 1 from public.tournaments t where t.id = tournament_id and t.organizer_id = auth.uid())
  or exists (select 1 from public.team_members tm where tm.team_id = team_id and tm.user_id = auth.uid())
);
create policy "team managers register their teams" on public.tournament_registrations
for insert to authenticated with check (
  registered_by = auth.uid()
  and exists (select 1 from public.teams t where t.id = team_id and t.created_by = auth.uid())
);

-- Match data is readable by everyone when the tournament is published.
create policy "matches readable for published tournaments" on public.matches
for select to anon, authenticated using (
  exists (select 1 from public.tournaments t where t.id = tournament_id and (t.status = 'published' or t.organizer_id = auth.uid()))
);
create policy "organizers manage matches" on public.matches
for all to authenticated using (
  exists (select 1 from public.tournaments t where t.id = tournament_id and t.organizer_id = auth.uid())
) with check (
  exists (select 1 from public.tournaments t where t.id = tournament_id and t.organizer_id = auth.uid())
);

create policy "match events readable for visible matches" on public.match_events
for select to anon, authenticated using (
  exists (select 1 from public.matches m join public.tournaments t on t.id = m.tournament_id
    where m.id = match_id and (t.status = 'published' or t.organizer_id = auth.uid()))
);
create policy "organizers record match events" on public.match_events
for insert to authenticated with check (
  exists (select 1 from public.matches m join public.tournaments t on t.id = m.tournament_id
    where m.id = match_id and t.organizer_id = auth.uid())
);

-- Wallet details are private. Ledger mutations must be performed by trusted server-side logic.
create policy "users view own wallet account" on public.wallet_accounts
for select to authenticated using (user_id = auth.uid());
create policy "users view own wallet transactions" on public.wallet_transactions
for select to authenticated using (
  exists (select 1 from public.wallet_accounts wa where wa.id = wallet_account_id and wa.user_id = auth.uid())
);

-- Intentionally no client-side INSERT/UPDATE/DELETE policies on wallet balances/ledger.
-- Implement verified payment webhooks and atomic ledger updates using server-side functions.
