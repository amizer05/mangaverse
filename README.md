# MangaVerse - Laravel Project

**MangaVerse** is een dynamische manga reading platform gebouwd met Laravel 12. Het project biedt een complete oplossing voor het lezen, beheren en delen van manga content.

## 📋 Project Overzicht

MangaVerse is een full-featured manga reading platform met:
- Gebruikersauthenticatie en profielbeheer
- Manga catalogus met chapters en pagina's
- Nieuws en community features
- FAQ systeem
- Contact formulier met admin reply functionaliteit
- REST API met Sanctum authenticatie
- External manga API integratie (Jikan/MyAnimeList)

## 🚀 Installatie Instructies

### Vereisten

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/PostgreSQL/SQLite database
- Laravel Herd (of andere lokale development environment)

### Stap 1: Clone het project

```bash
git clone <repository-url>
cd mangaverse
```

### Stap 2: Installeer dependencies

```bash
# PHP dependencies
composer install

# JavaScript dependencies
npm install
```

### Stap 3: Configureer environment

Kopieer het `.env.example` bestand naar `.env`:

```bash
cp .env.example .env
```

Pas de database configuratie aan in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mangaverse
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Configureer ook de mail instellingen (voor contact formulier emails):

```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@mangaverse.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Stap 4: Genereer application key

```bash
php artisan key:generate
```

### Stap 5: Run migrations en seeders

```bash
php artisan migrate:fresh --seed
```

Dit zal:
- Alle database tabellen aanmaken
- De default admin user aanmaken
- Sample data genereren (manga, news, FAQ, etc.)

### Stap 6: Link storage

```bash
php artisan storage:link
```

Dit maakt een symbolische link aan zodat opgeslagen bestanden (images, covers) publiek toegankelijk zijn.

### Stap 7: Build assets

```bash
npm run build
```

Of voor development met hot reload:

```bash
npm run dev
```

### Stap 8: Start de development server

```bash
php artisan serve
```

De applicatie is nu beschikbaar op `http://localhost:8000`

## 👤 Admin Credentials

Na het runnen van de seeders, kun je inloggen met:

- **Username:** `admin`
- **Email:** `admin@ehb.be`
- **Password:** `Password!321`

## 📁 Project Structuur

```
mangaverse/
├── app/
│   ├── Console/Commands/      # Artisan commands
│   ├── Http/
│   │   ├── Controllers/        # 43 controllers
│   │   ├── Middleware/         # Custom middleware
│   │   ├── Requests/           # Form requests
│   │   └── Resources/          # API resources
│   ├── Mail/                   # Mailable classes
│   ├── Models/                 # 11 Eloquent models
│   └── Services/               # Business logic services
├── database/
│   ├── migrations/             # 20 database migrations
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories
├── resources/
│   ├── views/                  # Blade templates (72 views)
│   ├── css/                    # Stylesheets
│   └── js/                      # JavaScript
└── routes/
    ├── web.php                 # Web routes
    └── api.php                 # API routes
```

## ✨ Features

### Functionele Minimum Requirements

✅ **Login Systeem**
- Gebruikers kunnen inloggen en registreren
- Remember me functionaliteit
- Password reset
- Admin/User rollen systeem
- Admins kunnen gebruikers beheren en admin status toekennen

✅ **Profielpagina**
- Publieke profielpagina voor elke gebruiker
- Gebruikers kunnen eigen profiel aanpassen
- Username, verjaardag, profielfoto, "over mij" tekst

✅ **Laatste Nieuwtjes**
- Admins kunnen nieuwsitems CRUD
- Publieke nieuws lijst en detail pagina
- Nieuwsitems met titel, afbeelding, content, publicatiedatum

✅ **FAQ Pagina**
- FAQ items gegroepeerd per categorie
- Admins kunnen categorieën en items CRUD
- Publiek toegankelijk

✅ **Contact Pagina**
- Contactformulier voor bezoekers
- Email notificatie naar admin@ehb.be bij verzending
- Admins kunnen contactformulieren bekijken en beantwoorden via admin panel

### Extra Features

✅ **Contact Reply Systeem**
- Admins kunnen antwoorden op contactformulieren via admin panel
- Automatische email naar gebruiker met antwoord

✅ **News Comments**
- Gebruikers kunnen comments plaatsen op nieuwsartikelen
- Gebruikers kunnen eigen comments verwijderen

✅ **FAQ Request Systeem**
- Gebruikers kunnen vragen indienen voor FAQ
- Admins kunnen requests goedkeuren/afwijzen

✅ **Manga Reading Platform**
- Manga catalogus met covers
- Chapter reading systeem
- Favorites functionaliteit
- Genre filtering

✅ **REST API**
- Volledige API met Sanctum authenticatie
- Public, authenticated en admin endpoints
- API documentation beschikbaar

✅ **External Manga API Integratie**
- Integratie met Jikan (MyAnimeList) API
- Automatische synchronisatie van manga data en covers
- Admin tools voor API search en sync

✅ **Newsletter Subscriptions**
- Gebruikers kunnen zich inschrijven voor newsletter

## 🛠️ Technische Details

### Models & Relationships

**11 Eloquent Models:**
- User
- Manga
- Chapter
- ChapterPage
- News
- NewsComment
- Contact
- FaqCategory
- FaqItem
- FaqRequest
- NewsletterSubscription

**Relationships:**
- **One-to-Many:**
  - User → News (if user_id exists)
  - User → NewsComments
  - User → Contacts (if user_id exists)
  - Manga → Chapters
  - Chapter → ChapterPages
  - FaqCategory → FaqItems
  - News → NewsComments

- **Many-to-Many:**
  - User ↔ Manga (Favorites)

### Controllers

**43 Controllers** georganiseerd in:
- Public controllers (MangaController, NewsController, etc.)
- Admin controllers (Admin namespace)
- API controllers (Api namespace)
- Auth controllers

### Security

- ✅ XSS protection (Blade escaping)
- ✅ CSRF protection (Laravel middleware)
- ✅ SQL injection protection (Eloquent ORM)
- ✅ Password hashing (bcrypt)
- ✅ Input validation (Form Requests)
- ✅ Authorization (Middleware & Policies)

### Database

- **20 Migrations** voor alle tabellen
- **Seeders** voor default data
- Database werkt met `php artisan migrate:fresh --seed`

## 📚 Artisan Commands

### Demo Data Genereren

```bash
# Genereer placeholder images voor manga covers
php artisan images:generate-placeholders

# Genereer demo chapters met placeholder pages
php artisan chapters:generate-demo --manga=one-piece --count=3 --pages=10

# Sync manga van externe API
php artisan manga:sync --title="One Piece"
php artisan manga:sync --top=10

# Genereer news images
php artisan news:generate-images

# Assign manga covers aan news items
php artisan news:assign-images
```

## 🔌 API Documentatie

Volledige API documentatie is beschikbaar in:
- `API_DOCUMENTATION.md` - Complete API reference
- `API_SETUP.md` - Quick start guide

API endpoints zijn beschikbaar op `/api/*` met Sanctum authenticatie.

## 🎨 Design & Layout

- **Framework:** Tailwind CSS
- **Theme:** Dark mode met gradient accenten (purple/pink)
- **Responsive:** Mobile-first design
- **Layouts:** 
  - Public layout (homepage, manga, news)
  - Guest layout (login, register)
  - App layout (dashboard, admin)

## 📝 Bronvermeldingen

### Libraries & Packages

- **Laravel Framework 12.41.1** - https://laravel.com
- **Laravel Breeze** - Authentication scaffolding - https://laravel.com/docs/breeze
- **Laravel Sanctum** - API authentication - https://laravel.com/docs/sanctum
- **Tailwind CSS** - Utility-first CSS framework - https://tailwindcss.com
- **Alpine.js** - Lightweight JavaScript framework - https://alpinejs.dev
- **Guzzle HTTP Client** - HTTP client voor API calls - https://docs.guzzlephp.org
- **Intervention Image** - Image manipulation - https://image.intervention.io

### External APIs

- **Jikan API** - MyAnimeList unofficial API - https://jikan.moe
  - Gebruikt voor manga data synchronisatie
  - Covers, descriptions, genres, release dates

### Code References

- **Laravel Documentation** - https://laravel.com/docs
  - Routing, Controllers, Models, Migrations
  - Authentication, Authorization, Middleware
  - Eloquent Relationships, Form Requests

- **Tailwind CSS Documentation** - https://tailwindcss.com/docs
  - Utility classes, Responsive design
  - Dark mode, Custom colors

## 🧪 Testing

```bash
# Run tests
php artisan test
```

## 📦 Dependencies

### Production
- `laravel/framework: ^12.0`
- `laravel/sanctum: ^4.2`
- `guzzlehttp/guzzle: ^7.10`
- `intervention/image: ^3.11`

### Development
- `laravel/breeze: ^2.3`
- `laravel/pint: ^1.24`
- `phpunit/phpunit: ^11.5.3`

## 🔧 Configuratie

### Belangrijke Config Files

- `.env` - Environment variabelen
- `config/database.php` - Database configuratie
- `config/mail.php` - Mail configuratie
- `config/sanctum.php` - API authenticatie
- `config/services.php` - External services (social links)

### Storage

- `storage/app/public/` - Publieke bestanden (images, covers)
- `storage/logs/` - Application logs

## 📄 Licentie

Dit project is gemaakt voor educatieve doeleinden als onderdeel van de cursus "Backend Web" aan de Erasmushogeschool Brussel.

## 👨‍💻 Auteur

**Amine Zerouali**
- Student Toegepaste Informatica (2de jaar Bachelor)
- Erasmushogeschool Brussel
- Academiejaar 2025-26

## 📞 Support

Voor vragen of problemen, gebruik het contactformulier op de website of open een issue in de repository.

---

**Let op:** Dit project is gemaakt voor educatieve doeleinden. Zorg ervoor dat je de juiste licenties hebt voor eventuele gebruikte content (manga covers, images, etc.).
