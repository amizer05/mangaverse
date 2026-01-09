# 🔐 GitHub Token Maken - Stap voor Stap

## 📍 Stap 1: Ga naar GitHub Settings

**Directe link:** https://github.com/settings/tokens

Of volg deze stappen:
1. Ga naar: https://github.com
2. Klik rechtsboven op je **profiel foto** (of avatar)
3. Klik op **"Settings"**
4. Scroll naar beneden in het linker menu
5. Klik op **"Developer settings"** (onderaan)
6. Klik op **"Personal access tokens"**
7. Klik op **"Tokens (classic)"**

## 📍 Stap 2: Maak Nieuwe Token

1. Klik op de groene knop **"Generate new token"**
2. Kies **"Generate new token (classic)"**
3. Vul in:
   - **Note:** `MangaVerse Project`
   - **Expiration:** Kies een periode (bijv. 90 days)
   - **Scopes:** Scroll naar beneden en vink **`repo`** aan
     - ✅ Dit geeft volledige toegang tot repositories
4. Scroll helemaal naar beneden
5. Klik op **"Generate token"** (groene knop)
6. **⚠️ BELANGRIJK:** Kopieer de token DIRECT! (Je ziet hem maar 1x)
   - Het begint met `ghp_` gevolgd door een lange reeks letters en cijfers

## 📍 Stap 3: Push naar GitHub

Open Terminal (of iTerm) en typ:

```bash
cd /Users/aminezerouali/Herd/mangaverse
git push -u origin main
```

Wanneer gevraagd:
- **Username:** `amizer05`
- **Password:** [Plak hier je token die je net hebt gekopieerd]

## ✅ Stap 4: Controleer

Ga naar: https://github.com/amizer05/mangaverse

Je zou nu ALLE bestanden moeten zien:
- ✅ app/ folder
- ✅ config/ folder
- ✅ database/ folder
- ✅ resources/ folder
- ✅ routes/ folder
- ✅ README.md
- ✅ composer.json
- ✅ En alle andere Laravel bestanden

**NIET zichtbaar:**
- ❌ vendor/ folder
- ❌ node_modules/ folder
- ❌ .env file

## 🔗 Handige Links

- **Repository:** https://github.com/amizer05/mangaverse
- **Tokens pagina:** https://github.com/settings/tokens
- **Developer settings:** https://github.com/settings/apps

## ❓ Problemen?

Als je de tokens pagina niet kunt vinden:
1. Zorg dat je ingelogd bent op GitHub
2. Gebruik de directe link: https://github.com/settings/tokens
3. Of ga via: GitHub → Je profiel foto → Settings → Developer settings → Personal access tokens → Tokens (classic)

## 💡 Alternatief: GitHub CLI

Als tokens niet werken, gebruik GitHub CLI:

```bash
# Installeer GitHub CLI
brew install gh

# Login
gh auth login
# Kies: GitHub.com → HTTPS → Login with web browser
# Volg de instructies in je browser

# Push
cd /Users/aminezerouali/Herd/mangaverse
git push -u origin main
```






