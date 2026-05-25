<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            'lea' => [
                'name' => 'Léa Dubois',
                'initials' => 'LD',
                'role' => 'Responsable produit chez GymFlow',
                'bio' => 'Responsable produit chez GymFlow. Ancienne gérante de salle, elle écrit sur la gestion, la donnée et la croissance des clubs de fitness.',
            ],
            'marc' => [
                'name' => 'Marc Petit',
                'initials' => 'MP',
                'role' => 'Coach & consultant fitness',
                'bio' => "Coach et consultant fitness. Il accompagne les salles de sport sur la rétention, le coaching et l'expérience membre.",
            ],
            'sophie' => [
                'name' => 'Sophie Laurent',
                'initials' => 'SL',
                'role' => 'Spécialiste marketing chez GymFlow',
                'bio' => "Spécialiste marketing chez GymFlow. Elle écrit sur l'acquisition, la communication et la fidélisation dans les clubs de sport.",
            ],
        ];

        $posts = [
            [
                'author' => 'lea',
                'category' => 'Gestion',
                'title' => '5 indicateurs à suivre pour piloter votre salle de sport en 2026',
                'excerpt' => "Taux de rétention, fréquentation, revenu par membre… Découvrez les KPIs essentiels et comment les suivre automatiquement avec GymFlow pour prendre de meilleures décisions.",
                'read_minutes' => 6,
                'is_featured' => true,
                'published_at' => Carbon::create(2026, 5, 24, 9, 0),
                'tags' => ['Rétention', 'KPI', 'Gestion', 'Croissance'],
                'body' => <<<'HTML'
<p>La plupart des gérants de salle savent combien de membres ils ont. Très peu savent combien ils en perdent chaque mois, ni pourquoi. Pourtant, c'est dans ces chiffres que se cache la croissance. Voici les cinq indicateurs que nous recommandons de suivre de près — et que GymFlow calcule automatiquement pour vous.</p>
<h2>1. Le taux de rétention mensuel</h2>
<p>C'est le pourcentage de membres qui renouvellent leur abonnement d'un mois sur l'autre. Un taux sain se situe au-dessus de 85%. En dessous, chaque nouvel inscrit ne fait que compenser un départ : vous courez sans avancer. Suivez-le par cohorte pour repérer à quel moment du parcours vos membres décrochent.</p>
<h2>2. La fréquentation par créneau</h2>
<p>Tous les créneaux ne se valent pas. En croisant les présences avec les horaires, vous identifiez vos heures creuses et vos cours saturés. C'est la base pour rééquilibrer votre planning, ouvrir un second créneau sur un cours populaire, ou repositionner un cours qui ne prend pas.</p>
<blockquote>« Depuis qu'on suit notre rétention chaque semaine, on a réduit nos départs de 30%. On agit avant que le membre ne parte, pas après. »</blockquote>
<h2>3. Le revenu moyen par membre</h2>
<p>L'ARPU (<strong>Average Revenue Per User</strong>) révèle la valeur réelle de chaque adhérent. En le suivant, vous voyez immédiatement l'effet d'une nouvelle offre, d'un coaching premium ou d'une vente additionnelle. Augmenter l'ARPU de quelques euros est souvent plus rentable que de courir après de nouveaux membres.</p>
<p>Pour l'améliorer, concentrez-vous sur trois leviers :</p>
<ul>
<li>Des formules à paliers qui valorisent l'engagement long terme</li>
<li>Des services additionnels : coaching individuel, nutrition, accès premium</li>
<li>Des partenariats locaux qui enrichissent l'expérience sans coût fixe</li>
</ul>
<h2>4. Le taux de remplissage des cours</h2>
<p>Un cours à moitié vide coûte autant qu'un cours plein, mais rapporte deux fois moins. En suivant le remplissage moyen, vous savez quels formats fonctionnent et lesquels méritent d'être repensés. La réservation en ligne vous donne en prime une visibilité en temps réel sur la demande.</p>
<h2>5. Le délai de conversion des prospects</h2>
<p>Combien de temps s'écoule entre la première visite et l'inscription ? Plus ce délai est court, plus votre tunnel est efficace. Un prospect qui hésite trois semaines a souvent déjà choisi un concurrent. Automatisez les relances et offrez un essai sans friction pour raccourcir ce cycle.</p>
<h2>En résumé</h2>
<p>Ces cinq indicateurs forment un tableau de bord minimal mais redoutablement efficace. Pris ensemble, ils vous disent non seulement où vous en êtes, mais surtout où agir en priorité. GymFlow les calcule pour vous en continu — il ne vous reste plus qu'à décider.</p>
HTML,
            ],
            [
                'author' => 'lea',
                'category' => 'Coaching',
                'title' => 'Comment fidéliser vos membres dès le premier mois',
                'excerpt' => "Les 30 premiers jours sont décisifs. Voici un parcours d'onboarding qui transforme un essai en abonnement durable.",
                'read_minutes' => 5,
                'published_at' => Carbon::create(2026, 5, 18, 9, 0),
                'tags' => ['Onboarding', 'Rétention', 'Coaching'],
                'body' => <<<'HTML'
<p>Un nouveau membre prend sa décision de rester bien plus tôt qu'on ne le croit. Les études convergent : la majorité des résiliations se jouent dans les quatre premières semaines. Bonne nouvelle — c'est aussi la période où vous avez le plus d'influence.</p>
<h2>Soignez les 7 premiers jours</h2>
<p>Un message de bienvenue personnalisé, une première séance accompagnée et un objectif clair suffisent à créer un attachement. Le membre doit sentir qu'il est attendu, pas juste encaissé.</p>
<h2>Créez des repères</h2>
<p>Proposez un parcours simple sur le premier mois : trois cours à tester, un bilan à mi-parcours, une petite victoire à célébrer. La régularité naît de la clarté.</p>
<ul>
<li>Un coach référent identifié dès l'inscription</li>
<li>Des relances automatiques en cas d'absence prolongée</li>
<li>Un point de contact humain à la fin du premier mois</li>
</ul>
<p>Avec GymFlow, ce parcours se déclenche tout seul : vous gardez le contact sans y penser, et vos membres restent.</p>
HTML,
            ],
            [
                'author' => 'marc',
                'category' => 'Marketing',
                'title' => 'Remplir vos cours collectifs grâce à la réservation en ligne',
                'excerpt' => "La réservation en ligne réduit les absences de 40%. On vous explique comment la mettre en place.",
                'read_minutes' => 5,
                'published_at' => Carbon::create(2026, 5, 12, 9, 0),
                'tags' => ['Réservation', 'Cours collectifs', 'Marketing'],
                'body' => <<<'HTML'
<p>Un cours collectif vit de son énergie de groupe. Quand la salle est à moitié vide, l'expérience se dégrade pour tout le monde. La réservation en ligne est l'outil le plus simple pour remplir vos créneaux — et fiabiliser la présence.</p>
<h2>Pourquoi ça marche</h2>
<p>Réserver crée un engagement. Un membre qui a bloqué sa place vient plus volontiers, et une liste d'attente transforme la rareté en motivation. Résultat observé chez nos clients : jusqu'à 40% d'absences en moins.</p>
<h2>Mettre en place sans friction</h2>
<ul>
<li>Ouvrez les réservations 7 jours à l'avance</li>
<li>Activez une liste d'attente automatique</li>
<li>Envoyez un rappel la veille du cours</li>
</ul>
<p>Le tout se configure en quelques minutes dans GymFlow, et vos coachs voient la liste des participants en temps réel.</p>
HTML,
            ],
            [
                'author' => 'sophie',
                'category' => 'Témoignages',
                'title' => 'CrossBox Liège : +120 membres en 6 mois avec GymFlow',
                'excerpt' => "Rencontre avec Julie, gérante de CrossBox, qui a digitalisé toute sa gestion en quelques semaines.",
                'read_minutes' => 4,
                'published_at' => Carbon::create(2026, 5, 6, 9, 0),
                'tags' => ['Témoignage', 'CrossFit', 'Croissance'],
                'body' => <<<'HTML'
<p>Quand Julie a repris CrossBox Liège, tout passait encore par un tableur et un cahier de présence. Six mois après son passage sur GymFlow, sa box a gagné plus de 120 membres. Retour sur une transition express.</p>
<h2>Le déclic</h2>
<p>« Je passais mes dimanches soir à recopier des paiements », raconte-t-elle. La centralisation des abonnements et des présences lui a immédiatement rendu plusieurs heures par semaine.</p>
<blockquote>« GymFlow m'a redonné du temps pour ce qui compte : mes membres et mes coachs. »</blockquote>
<h2>Les résultats</h2>
<ul>
<li>+120 membres en six mois</li>
<li>Réservations en ligne adoptées par 9 membres sur 10</li>
<li>Zéro paiement oublié grâce aux relances automatiques</li>
</ul>
HTML,
            ],
            [
                'author' => 'marc',
                'category' => 'Gestion',
                'title' => 'Automatiser le suivi des présences sans badgeuse coûteuse',
                'excerpt' => "Le check-in via QR code remplace avantageusement les systèmes physiques. Comparatif et mise en place.",
                'read_minutes' => 5,
                'published_at' => Carbon::create(2026, 4, 28, 9, 0),
                'tags' => ['Présences', 'QR code', 'Gestion'],
                'body' => <<<'HTML'
<p>Les badgeuses physiques coûtent cher, tombent en panne et n'apportent aucune donnée exploitable. Le check-in par QR code offre la même fiabilité, pour une fraction du prix — et bien plus d'informations.</p>
<h2>Comment ça fonctionne</h2>
<p>Chaque membre dispose d'un QR code dans son application. À l'entrée, le coach le scanne : la présence est enregistrée, l'abonnement vérifié, et la réservation validée en un geste.</p>
<h2>Ce que vous y gagnez</h2>
<ul>
<li>Aucun matériel coûteux à installer ni à maintenir</li>
<li>Des statistiques de fréquentation en temps réel</li>
<li>La vérification automatique des droits d'accès</li>
</ul>
<p>Vous transformez une simple formalité d'entrée en source de données pour piloter votre salle.</p>
HTML,
            ],
            [
                'author' => 'lea',
                'category' => 'Coaching',
                'title' => 'Construire des programmes qui gardent vos athlètes motivés',
                'excerpt' => "La progression visible est le meilleur moteur. Structurez vos cycles pour des résultats mesurables.",
                'read_minutes' => 6,
                'published_at' => Carbon::create(2026, 4, 22, 9, 0),
                'tags' => ['Programmation', 'Motivation', 'Coaching'],
                'body' => <<<'HTML'
<p>Rien ne fidélise autant qu'un résultat. Un membre qui voit ses progrès revient ; un membre qui stagne décroche. La clé tient dans la structure de vos programmes.</p>
<h2>Pensez en cycles</h2>
<p>Découpez l'entraînement en blocs de quatre à six semaines avec un objectif clair par bloc. Chaque cycle se termine par un test simple qui matérialise la progression.</p>
<h2>Rendez la progression visible</h2>
<ul>
<li>Notez les performances clés à chaque séance</li>
<li>Célébrez les records, même modestes</li>
<li>Ajustez la charge en fonction des données, pas du ressenti</li>
</ul>
<p>Avec un historique centralisé, vos coachs adaptent les programmes en un coup d'œil et gardent chaque athlète engagé.</p>
HTML,
            ],
            [
                'author' => 'sophie',
                'category' => 'Marketing',
                'title' => 'Le guide complet de la communication réseaux pour une salle',
                'excerpt' => "Instagram, TikTok, newsletter : quelle plateforme pour quel objectif ? Notre méthode pas à pas.",
                'read_minutes' => 7,
                'published_at' => Carbon::create(2026, 4, 15, 9, 0),
                'tags' => ['Réseaux sociaux', 'Acquisition', 'Marketing'],
                'body' => <<<'HTML'
<p>Être partout, c'est n'être nulle part. Avant de produire du contenu, demandez-vous ce que chaque canal doit accomplir pour votre salle. Voici comment répartir vos efforts intelligemment.</p>
<h2>Un objectif par plateforme</h2>
<ul>
<li><strong>Instagram</strong> : montrer l'ambiance et la communauté</li>
<li><strong>TikTok</strong> : attirer de nouveaux prospects avec des formats courts</li>
<li><strong>Newsletter</strong> : fidéliser et faire revenir les membres existants</li>
</ul>
<h2>Tenir le rythme sans s'épuiser</h2>
<p>Mieux vaut un post de qualité par semaine qu'un flot irrégulier. Planifiez un mois à l'avance, recyclez vos meilleurs contenus et appuyez-vous sur vos membres : leurs résultats sont votre meilleure publicité.</p>
<p>Reliez ensuite ces canaux à vos séances d'essai en ligne pour mesurer ce qui convertit réellement.</p>
HTML,
            ],
        ];

        foreach ($posts as $data) {
            $author = $authors[$data['author']];

            Post::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'category' => $data['category'],
                'excerpt' => $data['excerpt'],
                'body' => $data['body'],
                'cover_image' => 'images/gym-hero.png',
                'author_name' => $author['name'],
                'author_initials' => $author['initials'],
                'author_role' => $author['role'],
                'author_bio' => $author['bio'],
                'tags' => $data['tags'],
                'read_minutes' => $data['read_minutes'],
                'is_featured' => $data['is_featured'] ?? false,
                'published_at' => $data['published_at'],
            ]);
        }
    }
}
