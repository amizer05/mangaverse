# GitHub Repository Setup - MangaVerse

## ✅ Git Repository Status

- ✅ Git repository is geïnitialiseerd
- ✅ Branch naam: `main`
- ✅ Eerste commit is gemaakt
- ✅ `.gitignore` bevat `vendor` en `node_modules` ✓
- ✅ README.md bestaat en is compleet

## 📝 Volgende Stappen voor GitHub

### Stap 1: Maak een GitHub Repository aan

1. Ga naar [GitHub.com](https://github.com) en log in
2. Klik op het **"+"** icoon rechtsboven → **"New repository"**
3. Vul in:
   - **Repository name:** `mangaverse` (of een andere naam)
   - **Description:** "MangaVerse - Laravel manga reading platform"
   - **Visibility:** **Public** (belangrijk voor de docent!)
   - **DON'T** initialiseer met README, .gitignore, of license (we hebben die al)
4. Klik op **"Create repository"**

### Stap 2: Koppel lokale repository aan GitHub

Na het aanmaken van de repository krijg je instructies. Voer deze commando's uit:

```bash
cd /Users/aminezerouali/Herd/mangaverse

# Voeg GitHub remote toe (vervang <jouw-username> met je GitHub username)
git remote add origin https://github.com/<jouw-username>/mangaverse.git

# Push naar GitHub
git push -u origin main
```

**Of als je SSH gebruikt:**
```bash
git remote add origin git@github.com:<jouw-username>/mangaverse.git
git push -u origin main
```

### Stap 3: Verifieer

1. Ga naar je GitHub repository pagina
2. Controleer of alle bestanden zichtbaar zijn
3. Controleer dat `vendor/` en `node_modules/` **NIET** zichtbaar zijn
4. Controleer dat `.env` **NIET** zichtbaar is

### Stap 4: Test Clone (Belangrijk!)

Test of de docent het project kan clonen:

```bash
# Test in een andere directory
cd /tmp
git clone https://github.com/<jouw-username>/mangaverse.git test-clone
cd test-clone
ls -la

# Controleer dat .env.example bestaat maar .env niet
# Controleer dat vendor en node_modules niet bestaan
```

### Stap 5: Voeg extra commits toe (optioneel maar aanbevolen)

Als je nog wijzigingen maakt, commit regelmatig:

```bash
git add .
git commit -m "Beschrijving van wat je hebt toegevoegd/gewijzigd"
git push
```

## ⚠️ Belangrijke Checklist voor Inzending

- [ ] Repository is **PUBLIC** (niet private!)
- [ ] Repository bevat alle project bestanden
- [ ] `vendor/` en `node_modules/` zijn **NIET** in de repository
- [ ] `.env` is **NIET** in de repository (maar `.env.example` wel)
- [ ] README.md is compleet en bevat installatie instructies
- [ ] README.md bevat bronvermeldingen
- [ ] Je kunt het project clonen en installeren volgens README.md
- [ ] Database seeder werkt (`php artisan migrate:fresh --seed`)
- [ ] Default admin account werkt (admin@ehb.be / Password!321)

## 📋 Commit Best Practices

Maak duidelijke commit messages:

```bash
# Goede voorbeelden:
git commit -m "Add user authentication with login and registration"
git commit -m "Implement manga CRUD operations for admin"
git commit -m "Add FAQ system with categories and items"
git commit -m "Fix contact form validation issue"
git commit -m "Update admin dashboard with dark theme"

# Slechte voorbeelden (niet doen):
git commit -m "fix"
git commit -m "update"
git commit -m "changes"
```

## 🔗 Repository Link voor Inzending

Zodra je repository klaar is, gebruik deze link voor inzending:

```
https://github.com/<jouw-username>/mangaverse
```

**Zorg ervoor dat de repository PUBLIC is!**

## ✅ Final Check

Voordat je inlevert, test dit:

```bash
# In een nieuwe directory
cd /tmp
rm -rf mangaverse-test
git clone https://github.com/<jouw-username>/mangaverse.git mangaverse-test
cd mangaverse-test

# Volg de installatie instructies uit README.md
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed

# Test of alles werkt
php artisan serve
```

Als dit werkt, ben je klaar! 🎉






