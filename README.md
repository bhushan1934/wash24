<div align="center">

# 🧺 Wash24 — API (Laravel)

**OTP-authenticated backend for a laundry/car-wash booking service, deployed serverless on Vercel**

A Laravel REST API: mobile-number + OTP registration and login (via Laravel
Passport tokens), user profile management, deployed as a PHP serverless
function on Vercel rather than a traditional long-running server.

[![View Repository](https://img.shields.io/badge/GitHub-View%20Repository-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/bhushan1934/wash24)

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8-777BB4?logo=php&logoColor=white)
![Vercel](https://img.shields.io/badge/Deploy-Vercel%20serverless-000000?logo=vercel&logoColor=white)
![License](https://img.shields.io/badge/license-proprietary-red)

</div>

<br>

## Status

This is the **first of two implementations** of the same product in this
account — see [`nest-wash24`](https://github.com/bhushan1934/nest-wash24)
for a later NestJS/Prisma rewrite with a more complete data model
(address/society fields, a dashboard endpoint). This Laravel version is the
earlier pass: auth and profile scaffolding is in place, the actual
wash/booking domain (services, pricing, scheduling) hadn't been built yet.

<br>

## API surface

| Method | Route | Auth | Does |
|---|---|---|---|
| POST | `/api/register` | — | Create (or find) a user by mobile number, issue a 4-digit OTP |
| POST | `/api/generate-otp` | — | Re-issue an OTP for an existing user |
| POST | `/api/verify-otp` | — | Verify an OTP |
| POST | `/api/login` | — | Verify mobile + OTP, issue a Passport access token |
| POST | `/api/logout` | token | Revoke the current token |
| POST | `/api/user/profile` | token | Create the authenticated user's profile (name, gender, address) |
| GET | `/api/users` / `/api/get-user` | token | Fetch the authenticated user (with profile) |

<br>

## Deployment: Laravel as a Vercel serverless function

`api/index.php` + `api/vercel.json` run the whole Laravel app through the
community `@vercel/php` runtime rather than a persistent PHP-FPM process.
Vercel's filesystem is read-only outside `/tmp`, so the config points
Laravel's config/route/view/event caches at `/tmp/*` and switches
`CACHE_DRIVER`/`SESSION_DRIVER` to array/cookie-based storage — the usual
adjustments needed to make a stateful framework behave on a stateless
function host.

<br>

## Running it locally

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

<br>

## Known gaps (flagging honestly, not silently patched)

- **OTP is returned directly in the API response** (`registerAndGenerateOtp`
  returns `'otp' => $otp` in the JSON body) and actual SMS delivery is a
  `// TODO` comment, not implemented. Fine for local development; this
  **must** be removed and wired to a real SMS provider (Twilio/MSG91/etc.)
  before this is anywhere near production — right now anyone who can call
  the endpoint can read the OTP without needing the phone.
- Only `User` and `UserProfile` models exist — no booking/service/pricing
  domain yet.

<br>

## License

All rights reserved — see [`LICENSE`](LICENSE). Shared for portfolio/review
purposes; not licensed for reuse, redistribution, or derivative work.
