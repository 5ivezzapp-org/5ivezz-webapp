import { supabase, isSupabaseConfigured } from "../lib/supabase";

export type Tournament = {
  id: string;
  name: string;
  description: string | null;
  location: string | null;
  start_date: string | null;
  end_date: string | null;
  format: string | null;
  status: "draft" | "published" | "in_progress" | "completed" | "cancelled";
  registration_fee_kobo: number;
  created_at: string;
};

function client() {
  if (!isSupabaseConfigured || !supabase) {
    throw new Error("Configure Supabase in .env.local before using tournament data.");
  }
  return supabase;
}

/** Public tournament discovery: only published and active tournaments are returned. */
export async function listPublishedTournaments() {
  const { data, error } = await client()
    .from("tournaments")
    .select("id,name,description,location,start_date,end_date,format,status,registration_fee_kobo,created_at")
    .eq("status", "published")
    .order("start_date", { ascending: true, nullsFirst: false });
  if (error) throw error;
  return (data ?? []) as Tournament[];
}

/** Creates a draft tournament owned by the signed-in organizer. */
export async function createTournament(input: {
  name: string;
  description?: string;
  location?: string;
  start_date?: string;
  end_date?: string;
  format?: string;
  registration_fee_kobo?: number;
}) {
  const { data, error } = await client()
    .from("tournaments")
    .insert({
      ...input,
      status: "draft",
    })
    .select()
    .single();
  if (error) throw error;
  return data as Tournament;
}
