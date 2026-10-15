import { supabase, isSupabaseConfigured, type AppRole } from "../lib/supabase";

export type SignUpInput = {
  email: string;
  password: string;
  fullName: string;
  role: Exclude<AppRole, "admin">;
};

function requireBackend() {
  if (!isSupabaseConfigured || !supabase) {
    throw new Error(
      "Backend is not configured. Copy .env.example to .env.local and add your Supabase URL and publishable/anon key.",
    );
  }
  return supabase;
}

export async function signUp(input: SignUpInput) {
  const client = requireBackend();
  const { data, error } = await client.auth.signUp({
    email: input.email.trim().toLowerCase(),
    password: input.password,
    options: {
      data: {
        full_name: input.fullName.trim(),
        role: input.role,
      },
    },
  });
  if (error) throw error;
  return data;
}

export async function signIn(email: string, password: string) {
  const client = requireBackend();
  const { data, error } = await client.auth.signInWithPassword({
    email: email.trim().toLowerCase(),
    password,
  });
  if (error) throw error;
  return data;
}

export async function signOut() {
  const client = requireBackend();
  const { error } = await client.auth.signOut();
  if (error) throw error;
}

export async function getCurrentSession() {
  const client = requireBackend();
  const { data, error } = await client.auth.getSession();
  if (error) throw error;
  return data.session;
}
