# 🚀 Snel Push naar GitHub

## Snelle Methode (2 minuten)

### Stap 1: Maak Personal Access Token

1. Ga naar: **https://github.com/settings/tokens**
2. Klik op **"Generate new token (classic)"**
3. Vul in:
   - **Note:** `MangaVerse Project`
   - **Expiration:** Kies een periode (bijv. 90 dagen)
   - **Scopes:** Vink **`repo`** aan (volledige toegang)
4. Klik **"Generate token"**
5. **⚠️ BELANGRIJK:** Kopieer de token direct! (Je ziet hem maar 1x)

### Stap 2: Push naar GitHub

Open Terminal en voer uit:

```bash
cd /Users/aminezerouali/Herd/mangaverse
git push -u origin main
```

Wanneer je wordt gevraagd om:
- **Username:** `amizer05`
- **Password:** Plak hier je **Personal Access Token** (niet je GitHub wachtwoord!)

### Stap 3: Verifieer

Ga naar: **https://github.com/amizer05/mangaverse**

Controleer:
- ✅ Alle bestanden zijn zichtbaar
- ✅ `vendor/` en `node_modules/` zijn **NIET** zichtbaar
- ✅ `.env` is **NIET** zichtbaar (maar `.env.example` wel)
- ✅ Repository is **PUBLIC**

## ✅ Klaar!

Je repository link voor inzending:
```
https://github.com/amizer05/mangaverse
```

---

## Alternatief: Gebruik het Push Script

Je kunt ook het automatische script gebruiken:

```bash
cd /Users/aminezerouali/Herd/mangaverse
./push.sh
```

Dit script helpt je door het hele proces!

