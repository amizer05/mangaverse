# 🔧 Token Probleem Oplossen

## ❌ Probleem: 403 Permission Denied

De token heeft waarschijnlijk niet de juiste permissions of is ongeldig.

## ✅ Oplossing: Genereer een Nieuwe Token

### Stap 1: Verwijder Oude Token (optioneel)
1. Ga naar: https://github.com/settings/tokens
2. Zoek je oude token en verwijder deze

### Stap 2: Genereer Nieuwe Token

1. Ga naar: **https://github.com/settings/tokens**
2. Klik op **"Generate new token (classic)"**
3. Vul in:
   - **Note:** `MangaVerse Project Push`
   - **Expiration:** Kies een periode (bijv. 90 dagen of No expiration)
   - **Scopes:** 
     - ✅ **`repo`** (volledige toegang tot repositories) - **BELANGRIJK!**
     - ✅ **`workflow`** (optioneel, voor GitHub Actions)
4. Scroll naar beneden en klik **"Generate token"**
5. **⚠️ BELANGRIJK:** Kopieer de token direct! (Je ziet hem maar 1x)

### Stap 3: Push met Nieuwe Token

```bash
cd /Users/aminezerouali/Herd/mangaverse

# Gebruik de nieuwe token
git remote set-url origin https://amizer05:JE_NIEUWE_TOKEN@github.com/amizer05/mangaverse.git
git push -u origin main

# Verwijder token uit URL (veiligheid)
git remote set-url origin https://github.com/amizer05/mangaverse.git
```

### Stap 4: Of Gebruik Interactive Push

```bash
cd /Users/aminezerouali/Herd/mangaverse
git push -u origin main
# Username: amizer05
# Password: [plak je nieuwe token hier]
```

## 🔍 Controleer Ook

1. **Repository bestaat:** https://github.com/amizer05/mangaverse
2. **Repository is PUBLIC** (niet private)
3. **Je bent ingelogd** op het juiste GitHub account
4. **Token heeft `repo` scope** (niet alleen `public_repo`)

## 💡 Alternatief: GitHub CLI

Als tokens niet werken, gebruik GitHub CLI:

```bash
# Installeer GitHub CLI
brew install gh

# Login
gh auth login
# Kies: GitHub.com
# Kies: HTTPS
# Kies: Login with a web browser
# Volg de instructies

# Push
cd /Users/aminezerouali/Herd/mangaverse
git push -u origin main
```

## ✅ Na Succesvolle Push

Ga naar: https://github.com/amizer05/mangaverse

Controleer:
- ✅ Alle bestanden zijn zichtbaar
- ✅ `vendor/` en `node_modules/` zijn **NIET** zichtbaar
- ✅ `.env` is **NIET** zichtbaar
- ✅ Repository is **PUBLIC**






