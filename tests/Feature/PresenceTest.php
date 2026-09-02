<?php

namespace Tests\Feature;

use App\Models\Cours;
use App\Models\Creneau;
use App\Models\Espace;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Les cinq contrôles de la validation de présence par QR code
 * (chapitre 10.3 du dossier), plus le cas nominal.
 */
class PresenceTest extends TestCase
{
    use RefreshDatabase;

    private User $coach;

    private User $membre;

    private Creneau $creneau;

    protected function setUp(): void
    {
        parent::setUp();

        $this->coach = User::factory()->create(['role' => 'coach']);
        $this->membre = User::factory()->create(['role' => 'member']);

        $espace = Espace::create(['name' => 'Salle 1']);
        $cours = Cours::create([
            'name' => 'HIIT',
            'sport_type' => 'fitness',
            'espace_id' => $espace->id,
            'coach_id' => $this->coach->id,
            'max_participants' => 10,
        ]);

        // Le créneau du jour, de 10h00 à 11h00.
        $this->creneau = Creneau::create([
            'cours_id' => $cours->id,
            'espace_id' => $espace->id,
            'coach_id' => $this->coach->id,
            'date' => now()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'places' => 10,
        ]);

        // On se place pendant le cours pour tous les tests, sauf ceux qui voyagent.
        $this->travelTo(now()->setTime(10, 30));
    }

    private function reservation(string $status = 'confirmed'): Reservation
    {
        return Reservation::create([
            'user_id' => $this->membre->id,
            'creneau_id' => $this->creneau->id,
            'status' => $status,
        ]);
    }

    private function scan(string $token, ?User $scanneur = null)
    {
        return $this->actingAs($scanneur ?? $this->coach)
            ->postJson('/api/presences', ['token' => $token]);
    }

    public function test_le_coach_valide_la_presence_avec_un_jeton_valide(): void
    {
        $reservation = $this->reservation();

        $this->scan($reservation->qrToken())
            ->assertOk()
            ->assertJsonPath('reservation.status', 'present')
            ->assertJsonPath('reservation.user.name', $this->membre->name);

        $this->assertSame('present', $reservation->fresh()->status);
    }

    public function test_un_jeton_dont_la_signature_est_fausse_est_refuse(): void
    {
        $reservation = $this->reservation();

        $this->scan($reservation->id.'.signaturebidon')->assertStatus(422);

        $this->assertSame('confirmed', $reservation->fresh()->status);
    }

    public function test_une_reservation_annulee_ne_peut_pas_etre_validee(): void
    {
        $reservation = $this->reservation('cancelled');

        $this->scan($reservation->qrToken())->assertStatus(422);
    }

    public function test_un_coach_ne_valide_pas_le_creneau_d_un_collegue(): void
    {
        $autreCoach = User::factory()->create(['role' => 'coach']);
        $reservation = $this->reservation();

        $this->scan($reservation->qrToken(), $autreCoach)->assertStatus(403);

        $this->assertSame('confirmed', $reservation->fresh()->status);
    }

    public function test_la_presence_ne_peut_pas_etre_validee_hors_de_la_fenetre_horaire(): void
    {
        $reservation = $this->reservation();

        // La veille au soir, depuis chez soi.
        $this->travelTo(now()->subDay());

        $this->scan($reservation->qrToken())->assertStatus(422);

        $this->assertSame('confirmed', $reservation->fresh()->status);
    }

    public function test_le_meme_jeton_ne_peut_pas_servir_deux_fois(): void
    {
        $reservation = $this->reservation();

        $this->scan($reservation->qrToken())->assertOk();
        $this->scan($reservation->qrToken())->assertStatus(422);
    }

    public function test_un_membre_ne_peut_pas_valider_de_presence(): void
    {
        $reservation = $this->reservation();

        $this->scan($reservation->qrToken(), $this->membre)->assertStatus(403);
    }

    public function test_le_membre_recupere_le_qr_code_de_sa_reservation(): void
    {
        $reservation = $this->reservation();

        $this->actingAs($this->membre)
            ->get("/api/reservations/{$reservation->id}/qr")
            ->assertOk()
            ->assertHeader('Content-Type', 'image/svg+xml');
    }

    public function test_le_qr_code_d_une_reservation_n_est_pas_accessible_a_un_autre_membre(): void
    {
        $reservation = $this->reservation();

        $this->actingAs(User::factory()->create(['role' => 'member']))
            ->get("/api/reservations/{$reservation->id}/qr")
            ->assertStatus(403);
    }
}
