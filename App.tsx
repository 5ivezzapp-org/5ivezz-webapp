import { FormEvent, ReactNode, useState } from "react"

type Role = "player" | "manager" | "organizer"
type Screen = "welcome" | "roles" | "login" | "dashboard"

const roleContent: Record<Role, {
  label: string
  shortLabel: string
  description: string
  dashboardTitle: string
  dashboardCopy: string
  primaryAction: string
  nav: string[]
}> = {
  player: {
    label: "Player",
    shortLabel: "Player",
    description:
      "Build your football identity, discover tournaments and get discovered.",
    dashboardTitle: "Your football journey starts here",
    dashboardCopy:
      "Complete your football identity, then find a team and discover real opportunities near you.",
    primaryAction: "Build my profile",
    nav: ["Home", "Discover", "My Football", "Wallet", "Profile"],
  },
  manager: {
    label: "Team Manager",
    shortLabel: "Manager",
    description: "Create, manage and grow your football team.",
    dashboardTitle: "Build your team on 5ivezz",
    dashboardCopy:
      "Create your team identity, invite real players and get ready for your first tournament.",
    primaryAction: "Create team",
    nav: ["Dashboard", "My Team", "Tournaments", "Wallet", "Profile"],
  },
  organizer: {
    label: "Tournament Organizer",
    shortLabel: "Organizer",
    description: "Create and manage tournaments digitally.",
    dashboardTitle: "Bring your tournament to life",
    dashboardCopy:
      "Set up your first competition, manage registrations and publish when everything is ready.",
    primaryAction: "Create tournament",
    nav: ["Dashboard", "Tournaments", "Registrations", "Wallet", "Profile"],
  },
}

function Icon({
  name,
  className = "size-5",
}: {
  name: string
  className?: string
}) {
  const paths: Record<string, ReactNode> = {
    arrow: (
      <>
        <path d="M5 12h14" />
        <path d="m13 6 6 6-6 6" />
      </>
    ),
    ball: (
      <>
        <circle cx="12" cy="12" r="9" />
        <path d="m12 8 3 2-1.2 3.5H10.2L9 10l3-2Z" />
        <path d="m12 3 0 5M3.5 9l5.5 1M5.5 17.5l4.7-4M18.5 17.5l-4.7-4M20.5 9 15 10" />
      </>
    ),
    shield: (
      <>
        <path d="M12 3 5 6v5c0 4.6 2.8 7.9 7 10 4.2-2.1 7-5.4 7-10V6l-7-3Z" />
        <path d="m9 12 2 2 4-4" />
      </>
    ),
    trophy: (
      <>
        <path d="M8 4h8v4c0 3-1.8 5-4 5s-4-2-4-5V4Z" />
        <path d="M8 6H5v1c0 2 1.2 3 3.5 3M16 6h3v1c0 2-1.2 3-3.5 3M12 13v4M8 20h8M9 17h6" />
      </>
    ),
    users: (
      <>
        <circle cx="9" cy="8" r="3" />
        <path d="M3.5 19v-1.5A4.5 4.5 0 0 1 8 13h2a4.5 4.5 0 0 1 4.5 4.5V19M16 5.5a3 3 0 0 1 0 5.8M16.5 14a4 4 0 0 1 4 4v1" />
      </>
    ),
    wallet: (
      <>
        <path d="M4 6.5h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2h12" />
        <path d="M16 11h4v4h-4a2 2 0 0 1 0-4Z" />
      </>
    ),
    bell: (
      <>
        <path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4" />
      </>
    ),
    user: (
      <>
        <circle cx="12" cy="8" r="4" />
        <path d="M4 21a8 8 0 0 1 16 0" />
      </>
    ),
    home: (
      <>
        <path d="m3 11 9-8 9 8" />
        <path d="M5 10v10h14V10M9 20v-6h6v6" />
      </>
    ),
    search: (
      <>
        <circle cx="10.5" cy="10.5" r="6.5" />
        <path d="m16 16 4.5 4.5" />
      </>
    ),
    chevron: <path d="m9 18 6-6-6-6" />,
    check: <path d="m5 12 4 4L19 6" />,
  }

  return (
    <svg
      aria-hidden="true"
      className={className}
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      strokeWidth="1.8"
      strokeLinecap="round"
      strokeLinejoin="round"
    >
      {paths[name]}
    </svg>
  )
}

function Logo({ light = false }: { light?: boolean }) {
  return (
    <div className={`brand-logo ${light ? "brand-logo-light" : ""}`}>
      <img src="/5ivezz-logo.png" alt="5ivezz" />
    </div>
  )
}

function Welcome({
  onStart,
  onLogin,
}: {
  onStart: () => void
  onLogin: () => void
}) {
  return (
    <main className="welcome-shell">
      <section className="welcome-hero">
        <nav className="topbar">
          <Logo light />
          <div className="desktop-nav" aria-label="Primary navigation">
            <button type="button">Discover</button>
            <button type="button">Live scores</button>
            <button type="button">About</button>
          </div>
          <button className="nav-login" type="button" onClick={onLogin}>
            Log in
          </button>
        </nav>

        <div className="hero-content">
          <div className="eyebrow">
            <span className="eyebrow-dot" />
            Built for the game we love
          </div>
          <h1>
            Your football.
            <br />
            <span>Your future.</span>
          </h1>
          <p>
            Build your identity, find your team and unlock real opportunities
            across Africa&apos;s football ecosystem.
          </p>
          <div className="hero-actions">
            <button className="primary-button" type="button" onClick={onStart}>
              Get started
              <Icon name="arrow" />
            </button>
            <button className="text-button" type="button" onClick={onLogin}>
              I already have an account
            </button>
          </div>
        </div>

        <div className="hero-proof">
          <div className="proof-icon">
            <Icon name="shield" />
          </div>
          <div>
            <strong>Real football. Real data.</strong>
            <span>No fake profiles or fabricated activity.</span>
          </div>
        </div>

        <p className="photo-credit">Photo by Falaq Lazuardi on Unsplash</p>
      </section>

      <aside className="welcome-panel">
        <div className="panel-top">
          <span>THE FOOTBALL NETWORK</span>
          <span>01 — 04</span>
        </div>
        <div className="panel-center">
          <div className="orbit orbit-one" />
          <div className="orbit orbit-two" />
          <div className="ball-mark">
            <Icon name="ball" className="size-12" />
          </div>
          <div className="float-card card-player">
            <span>01</span>
            <strong>Build your identity</strong>
            <small>Create a football profile that grows with every game.</small>
          </div>
          <div className="float-card card-team">
            <span>02</span>
            <strong>Find your team</strong>
            <small>Connect with the people who move your game forward.</small>
          </div>
          <div className="float-card card-grow">
            <span>03</span>
            <strong>Unlock opportunity</strong>
            <small>Be ready when the next chance arrives.</small>
          </div>
        </div>
        <div className="panel-footer">
          <span />
          <span />
          <span className="active" />
          <span />
        </div>
      </aside>
    </main>
  )
}

function RoleSelection({
  selectedRole,
  onSelect,
  onBack,
  onContinue,
}: {
  selectedRole: Role | null
  onSelect: (role: Role) => void
  onBack: () => void
  onContinue: () => void
}) {
  const icons: Record<Role, string> = {
    player: "ball",
    manager: "users",
    organizer: "trophy",
  }

  return (
    <main className="onboarding-shell">
      <header className="onboarding-header">
        <button className="back-button" type="button" onClick={onBack}>
          <span>←</span> Back
        </button>
        <Logo />
        <span className="step-label">STEP 1 OF 2</span>
      </header>

      <section className="role-section">
        <div className="section-kicker">CHOOSE YOUR PATH</div>
        <h1>How will you use 5ivezz?</h1>
        <p>
          Pick the role that best fits you today. You can expand your role as
          your football journey grows.
        </p>

        <div className="role-grid">
          {(Object.keys(roleContent) as Role[]).map((role, index) => {
            const content = roleContent[role]
            const selected = selectedRole === role
            return (
              <button
                key={role}
                type="button"
                className={`role-card ${selected ? "selected" : ""}`}
                onClick={() => onSelect(role)}
              >
                <span className="role-number">0{index + 1}</span>
                <span className="role-icon">
                  <Icon name={icons[role]} className="size-7" />
                </span>
                <strong>{content.label}</strong>
                <span className="role-copy">{content.description}</span>
                <span className="role-select">
                  {selected ? (
                    <>
                      <Icon name="check" className="size-4" /> Selected
                    </>
                  ) : (
                    <>
                      Choose role <Icon name="arrow" className="size-4" />
                    </>
                  )}
                </span>
              </button>
            )
          })}
        </div>

        <button
          className="continue-button"
          type="button"
          disabled={!selectedRole}
          onClick={onContinue}
        >
          Continue
          <Icon name="arrow" />
        </button>
        <p className="onboarding-note">
          Your role only controls what you see first. One account can grow with
          you.
        </p>
      </section>
    </main>
  )
}

function Login({
  onBack,
  onSubmit,
}: {
  onBack: () => void
  onSubmit: () => void
}) {
  const handleSubmit = (event: FormEvent) => {
    event.preventDefault()
    onSubmit()
  }

  return (
    <main className="login-shell">
      <section className="login-art">
        <button
          className="back-button back-button-light"
          type="button"
          onClick={onBack}
        >
          <span>←</span> Back
        </button>
        <Logo light />
        <div>
          <span className="section-kicker section-kicker-light">
            WELCOME BACK
          </span>
          <h1>Pick up where your game left off.</h1>
          <p>Your football identity, team and opportunities in one place.</p>
        </div>
      </section>
      <section className="login-form-wrap">
        <form className="login-form" onSubmit={handleSubmit}>
          <span className="section-kicker">SECURE SIGN IN</span>
          <h2>Log in to 5ivezz</h2>
          <p>Enter the details linked to your account.</p>
          <label>
            Email address
            <input type="email" placeholder="you@example.com" required />
          </label>
          <label>
            Password
            <input type="password" placeholder="Enter your password" required />
          </label>
          <div className="form-meta">
            <label className="remember">
              <input type="checkbox" /> Remember me
            </label>
            <button type="button">Forgot password?</button>
          </div>
          <button className="continue-button" type="submit">
            Log in <Icon name="arrow" />
          </button>
          <p className="secure-note">
            <Icon name="shield" className="size-4" />
            Your account is protected with secure authentication.
          </p>
        </form>
      </section>
    </main>
  )
}

function Dashboard({ role, onExit }: { role: Role onExit: () => void }) {
  const content = roleContent[role]
  const actionIcons =
    role === "player"
      ? ["trophy", "users", "ball", "wallet"]
      : role === "manager"
        ? ["users", "user", "trophy", "wallet"]
        : ["trophy", "users", "ball", "wallet"]
  const actions =
    role === "player"
      ? ["Discover tournaments", "Find a team", "My football", "Wallet"]
      : role === "manager"
        ? ["Create team", "Manage players", "Find tournament", "Wallet"]
        : ["Create tournament", "Registrations", "Match centre", "Wallet"]

  return (
    <main className="dashboard-shell">
      <header className="dashboard-header">
        <Logo />
        <div className="dashboard-role">
          <span>Viewing as</span>
          <strong>{content.shortLabel}</strong>
          <Icon name="chevron" className="size-4" />
        </div>
        <div className="header-actions">
          <button type="button" aria-label="Notifications">
            <Icon name="bell" />
          </button>
          <button
            className="avatar"
            type="button"
            onClick={onExit}
            aria-label="Exit dashboard"
          >
            <Icon name="user" />
          </button>
        </div>
      </header>

      <section className="dashboard-main">
        <div className="dashboard-intro">
          <span className="section-kicker">YOUR 5IVEZZ</span>
          <h1>Welcome to your game.</h1>
          <p>Your dashboard is ready. Now make your first move.</p>
        </div>

        <section className="activation-card">
          <div className="activation-copy">
            <span className="activation-tag">FIRST STEP</span>
            <h2>{content.dashboardTitle}</h2>
            <p>{content.dashboardCopy}</p>
            <button className="light-button" type="button">
              {content.primaryAction}
              <Icon name="arrow" />
            </button>
          </div>
          <div className="pitch-graphic" aria-hidden="true">
            <div className="pitch-line center-line" />
            <div className="pitch-circle" />
            <div className="pitch-goal" />
            <Icon name="ball" className="floating-ball" />
          </div>
        </section>

        <section className="dashboard-section">
          <div className="section-heading">
            <div>
              <span className="section-kicker">QUICK ACTIONS</span>
              <h2>What do you want to do?</h2>
            </div>
          </div>
          <div className="quick-grid">
            {actions.map((action, index) => (
              <button type="button" className="quick-action" key={action}>
                <span>
                  <Icon name={actionIcons[index]} />
                </span>
                <strong>{action}</strong>
                <Icon name="chevron" className="size-4" />
              </button>
            ))}
          </div>
        </section>

        <div className="dashboard-columns">
          <section className="empty-card">
            <div className="section-heading">
              <div>
                <span className="section-kicker">UPCOMING</span>
                <h2>Football activity</h2>
              </div>
              <span className="count-pill">0</span>
            </div>
            <div className="empty-state">
              <span className="empty-icon">
                <Icon name="ball" className="size-7" />
              </span>
              <strong>No upcoming football activity</strong>
              <p>
                Your fixtures, tournaments and team activity will appear here.
              </p>
            </div>
          </section>

          <section className="empty-card">
            <div className="section-heading">
              <div>
                <span className="section-kicker">OPPORTUNITIES</span>
                <h2>What&apos;s next</h2>
              </div>
              <span className="count-pill">0</span>
            </div>
            <div className="empty-state">
              <span className="empty-icon">
                <Icon name="trophy" className="size-7" />
              </span>
              <strong>No opportunities available yet</strong>
              <p>
                Real trials, scouting and football opportunities will show here.
              </p>
            </div>
          </section>
        </div>
      </section>

      <nav className="bottom-nav" aria-label="Dashboard navigation">
        {content.nav.map((item, index) => (
          <button
            className={index === 0 ? "active" : ""}
            type="button"
            key={item}
          >
            <Icon
              name={
                index === 0
                  ? "home"
                  : index === 1
                    ? "search"
                    : index === 3
                      ? "wallet"
                      : "user"
              }
            />
            <span>{item}</span>
          </button>
        ))}
      </nav>
    </main>
  )
}

export default function App() {
  const [screen, setScreen] = useState<Screen>("welcome")
  const [role, setRole] = useState<Role | null>(null)

  if (screen === "roles") {
    return (
      <RoleSelection
        selectedRole={role}
        onSelect={setRole}
        onBack={() => setScreen("welcome")}
        onContinue={() => role && setScreen("dashboard")}
      />
    )
  }

  if (screen === "login") {
    return (
      <Login
        onBack={() => setScreen("welcome")}
        onSubmit={() => {
          setRole("player")
          setScreen("dashboard")
        }}
      />
    )
  }

  if (screen === "dashboard" && role) {
    return <Dashboard role={role} onExit={() => setScreen("welcome")} />
  }

  return (
    <Welcome
      onStart={() => setScreen("roles")}
      onLogin={() => setScreen("login")}
    />
  )
}
