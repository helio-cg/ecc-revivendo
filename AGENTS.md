# AGENTS.md — ECC Revivendo

## What this is

Laravel 12 + PHP 8.4 + Filament 5 event registration system for "XXIII Revivendo" — a Catholic couples' encounter in Iguatu, CE, Brazil. Uses PIX payments via OpenPix/Woovi sandbox. Portuguese (pt_BR) throughout.

## Quick commands

```bash
composer dev          # starts server, queue, pail logs, vite concurrently
php artisan migrate   # run migrations
php artisan db:seed   # seeds parishes + admin user + 500 couple registrations
```

No CI/CD, no test suite configured (Pest is installed but unused).

## Architecture

- **Two registration types**: Couples (`Inscricao`) and Individual (`InscricaoIndividual`)
- **Payment flow**: Registration creates Invoice (polymorphic) → OpenPix charge → webhook callback (`/api/openpix/chargeCompleted`) marks paid
- **Admin panel**: Filament at `/admin`, top navigation, custom dashboard with stats widgets + PDF generation per parish
- **Consultar inscricao**: Phone-based lookup that also handles expired charges (auto-recreates in Woovi)

## Key paths

| What | Where |
|------|-------|
| Admin panel config | `app/Providers/Filament/AdminPanelProvider.php` |
| Couple registration | `app/Http/Controllers/InscricaoController.php` |
| Individual registration | `app/Http/Controllers/InscricaoIndividualController.php` |
| Phone lookup + payment fix | `app/Http/Controllers/ConsultarInscricao.php` |
| Payment webhook | `app/Http/OpenPix/Callback.php` |
| Filament resources | `app/Filament/Admin/Resources/{Inscritos,InscritoIndividuals}/` |
| OpenPix SDK singleton | `app/Providers/OpenPixServiceProvider.php` |
| Registration fee config | `config/app.php` → `'incricaoValor' => '100.00'` |
| PDF templates | `resources/views/pdf/` |

## Gotchas

- **Tailwind v4** — no `tailwind.config.js`, uses `@tailwindcss/vite` plugin. Config is in CSS via `@theme`.
- **DB host is `host.docker.internal`** (not `127.0.0.1`) because MySQL runs in a separate Docker network (`database.yml`).
- **Invoice `transactionID` is nullable** — can be null if Woovi API call failed during registration. `ConsultarInscricao::mostrar` handles creating missing invoices/charges.
- **InvoiceStatus enum values**: `Pendente`, `Pago`, `Reembolsado`, `Cancelado`, `Cortesia` — do NOT invent new values.
- **`telefone` field** is stripped to digits only via Form Request validation. Always `preg_replace('/\D/', '', ...)` before DB lookups.
- **Filament auto-discovers** Resources/Pages/Widgets from `app/Filament/Admin/` — just create files there.
- **Known bug from README**: PDF totals are calculating incorrectly.
