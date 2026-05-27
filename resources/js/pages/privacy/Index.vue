<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import LandingFooter from "@/components/landing/LandingFooter.vue";
import LandingNav from "@/components/landing/LandingNav.vue";

defineOptions({ layout: "" });

const lastUpdated = "27. Mai 2026";
</script>

<template>
    <Head title="Datenschutz — Peermitly" />

    <div class="bg-background text-foreground min-h-screen">
        <LandingNav />

        <main class="mx-auto max-w-3xl px-6 py-16 md:py-24">
            <header class="mb-12 space-y-3">
                <p
                    class="text-muted-foreground text-xs font-medium tracking-[0.18em] uppercase"
                >
                    Rechtliches
                </p>
                <h1
                    class="text-foreground text-4xl font-semibold tracking-tight md:text-5xl"
                >
                    Datenschutzerklärung
                </h1>
                <p class="text-muted-foreground text-sm">
                    Stand: {{ lastUpdated }}
                </p>
            </header>

            <article
                class="prose prose-sm dark:prose-invert text-foreground/90 max-w-none [&_a]:text-primary [&_a]:underline [&_h2]:text-foreground [&_h2]:mt-10 [&_h2]:mb-3 [&_h2]:text-xl [&_h2]:font-semibold [&_h3]:text-foreground [&_h3]:mt-6 [&_h3]:mb-2 [&_h3]:text-base [&_h3]:font-semibold [&_li]:my-1 [&_p]:my-3 [&_p]:leading-7 [&_ul]:my-3 [&_ul]:list-disc [&_ul]:pl-5"
            >
                <h2>1. Verantwortlicher</h2>
                <p>
                    Verantwortlich für die Datenverarbeitung auf dieser
                    Plattform ist der Betreiber von Peermitly. Anfragen zum
                    Datenschutz richten Sie bitte per E-Mail an
                    <a href="mailto:datenschutz@peermitly.de"
                        >datenschutz@peermitly.de</a
                    >.
                </p>

                <h2>2. Überblick</h2>
                <p>
                    Peermitly ist ein Dienst zur Verwaltung von Lizenzschlüsseln
                    und Aktivierungen. Wir verarbeiten nur die Daten, die für
                    den Betrieb des Dienstes notwendig sind: Account-Daten,
                    technische Logdaten und die von Ihnen selbst eingegebenen
                    Inhalte (Lizenzschlüssel, Produkte, Kunden, Teams).
                </p>

                <h2>3. Welche Daten verarbeiten wir?</h2>

                <h3>3.1 Account &amp; Authentifizierung</h3>
                <ul>
                    <li>Name, E-Mail-Adresse, Rolle</li>
                    <li>Gehashtes Passwort (bcrypt)</li>
                    <li>Optional registrierte Passkeys (WebAuthn-Credentials)</li>
                    <li>
                        Session-Cookies und Remember-Me-Token zur Anmeldung
                    </li>
                </ul>
                <p>
                    Rechtsgrundlage: Vertragserfüllung (Art. 6 Abs. 1 lit. b
                    DSGVO).
                </p>

                <h3>3.2 Anwendungsdaten</h3>
                <ul>
                    <li>Teams, Produkte, Kunden, Lizenzschlüssel</li>
                    <li>
                        Aktivierungen inkl. optionaler Hardware-ID (HWID),
                        falls vom Kunden bei der Lizenzaktivierung übermittelt
                    </li>
                    <li>Persönliche API-Tokens (Hashes)</li>
                </ul>
                <p>
                    Rechtsgrundlage: Vertragserfüllung (Art. 6 Abs. 1 lit. b
                    DSGVO).
                </p>

                <h3>3.3 Technische Logdaten</h3>
                <ul>
                    <li>
                        IP-Adresse, User-Agent und Zeitstempel bei Aufrufen
                        des API-Endpunkts <code>/api</code>
                    </li>
                    <li>
                        Login-Benachrichtigungen per E-Mail mit IP und
                        User-Agent zur Erkennung verdächtiger Anmeldungen
                    </li>
                    <li>
                        Aktivitätslogs für Lizenzschlüssel- und
                        Benutzer-Änderungen (wer hat was geändert)
                    </li>
                </ul>
                <p>
                    Rechtsgrundlage: berechtigtes Interesse an Sicherheit,
                    Missbrauchserkennung und Nachvollziehbarkeit (Art. 6 Abs. 1
                    lit. f DSGVO).
                </p>

                <h2>4. Eingesetzte Technologien</h2>
                <ul>
                    <li>
                        <strong>Laravel</strong> (PHP 8.4) als
                        Backend-Framework.
                    </li>
                    <li>
                        <strong>PostgreSQL</strong> als Datenbank für alle
                        anwendungsrelevanten Daten.
                    </li>
                    <li>
                        <strong>Redis</strong> für Sessions, Cache und die
                        Job-Queue (Laravel Horizon).
                    </li>
                    <li>
                        <strong>Inertia.js + Vue 3</strong> für das Frontend,
                        ohne externe Tracking-Skripte.
                    </li>
                    <li>
                        <strong>Spatie Passkeys</strong> für passwortlose
                        Anmeldung per WebAuthn.
                    </li>
                    <li>
                        <strong>Laravel Sanctum</strong> für die Ausstellung
                        persönlicher API-Tokens.
                    </li>
                </ul>

                <h2>5. Cookies &amp; lokale Speicherung</h2>
                <p>
                    Es werden ausschließlich technisch notwendige Cookies
                    gesetzt:
                </p>
                <ul>
                    <li>
                        <code>peermitly_session</code> — Session-Cookie zur
                        Aufrechterhaltung der Anmeldung
                    </li>
                    <li>
                        <code>XSRF-TOKEN</code> — Schutz vor
                        Cross-Site-Request-Forgery
                    </li>
                    <li>
                        <code>remember_web_*</code> — optional, wenn
                        „Angemeldet bleiben" gewählt wurde
                    </li>
                </ul>
                <p>
                    Es kommen keine Analyse-, Marketing- oder Drittanbieter-
                    Cookies zum Einsatz.
                </p>

                <h2>6. Drittdienste</h2>

                <h3>6.1 Schriften (Bunny Fonts)</h3>
                <p>
                    Schriftarten werden über
                    <a
                        href="https://fonts.bunny.net"
                        target="_blank"
                        rel="noopener noreferrer"
                        >fonts.bunny.net</a
                    >
                    geladen, einem datenschutzfreundlichen Alternativdienst zu
                    Google Fonts. IP-Adressen werden dort nicht protokolliert.
                </p>

                <h3>6.2 Statusseite (Better Stack)</h3>
                <p>
                    Unsere Statusseite
                    <a
                        href="https://peermitly.betteruptime.com/"
                        target="_blank"
                        rel="noopener noreferrer"
                        >peermitly.betteruptime.com</a
                    >
                    wird von Better Stack betrieben. Beim Aufruf werden Daten
                    von Better Stack verarbeitet.
                </p>

                <h3>6.3 E-Mail-Versand</h3>
                <p>
                    Transaktionale E-Mails (Login-Hinweise, Passwort-Reset)
                    werden über unseren Mail-Provider versendet. Empfängername
                    und E-Mail-Adresse werden dabei verarbeitet.
                </p>

                <h2>7. Speicherdauer</h2>
                <ul>
                    <li>
                        Account-Daten: bis zur Löschung des Accounts.
                    </li>
                    <li>
                        API-Request-Logs: 30 Tage, anschließend automatische
                        Löschung.
                    </li>
                    <li>
                        Aktivitätslogs: 12 Monate, anschließend automatische
                        Löschung.
                    </li>
                    <li>
                        Lizenz- und Aktivierungsdaten: für die Laufzeit der
                        Nutzung des Dienstes.
                    </li>
                </ul>

                <h2>8. Ihre Rechte</h2>
                <p>Sie haben jederzeit das Recht auf:</p>
                <ul>
                    <li>Auskunft (Art. 15 DSGVO)</li>
                    <li>Berichtigung (Art. 16 DSGVO)</li>
                    <li>Löschung (Art. 17 DSGVO)</li>
                    <li>Einschränkung der Verarbeitung (Art. 18 DSGVO)</li>
                    <li>Datenübertragbarkeit (Art. 20 DSGVO)</li>
                    <li>
                        Widerspruch gegen Verarbeitung auf Basis berechtigter
                        Interessen (Art. 21 DSGVO)
                    </li>
                    <li>
                        Beschwerde bei einer Aufsichtsbehörde (Art. 77 DSGVO)
                    </li>
                </ul>

                <h2>9. Sicherheit</h2>
                <p>
                    Übertragung erfolgt ausschließlich verschlüsselt per
                    HTTPS. Passwörter werden mit bcrypt gehasht. Passkeys
                    werden als WebAuthn-Credentials gespeichert; private
                    Schlüssel verlassen Ihr Gerät niemals.
                </p>

                <h2>10. Änderungen</h2>
                <p>
                    Diese Erklärung kann angepasst werden, wenn sich
                    technische oder rechtliche Rahmenbedingungen ändern. Die
                    aktuelle Fassung ist immer auf dieser Seite einsehbar.
                </p>
            </article>
        </main>

        <LandingFooter />
    </div>
</template>
