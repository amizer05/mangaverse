# Push naar GitHub - Instructies

## ✅ Status
- ✅ Git repository is geïnitialiseerd
- ✅ Remote is toegevoegd: `https://github.com/amizer05/mangaverse.git`
- ✅ Branch: `main`
- ✅ Alle bestanden zijn gecommit

## 🔐 Authenticatie Opties

Je hebt 3 opties om naar GitHub te pushen:

### Optie 1: GitHub Personal Access Token (Aanbevolen)

1. Ga naar GitHub.com → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Klik op "Generate new token (classic)"
3. Geef het een naam: "MangaVerse Project"
4. Selecteer scope: **`repo`** (volledige toegang)
5. Klik "Generate token"
6. **Kopieer de token** (je ziet hem maar 1x!)

7. Push met token:
```bash
cd /Users/aminezerouali/Herd/mangaverse
git push -u origin main
# Username: amizer05
# Password: [plak hier je token]
```

### Optie 2: GitHub CLI (Eenvoudigst)

```bash
# Installeer GitHub CLI (als je die nog niet hebt)
brew install gh

# Login
gh auth login

# Push
git push -u origin main
```

### Optie 3: SSH Key (Meest veilig voor lange termijn)

1. Genereer SSH key (als je die nog niet hebt):
```bash
ssh-keygen -t ed25519 -C "zerouali.amine1402@gmail.com"
# Druk Enter voor default locatie
# Druk Enter voor geen passphrase (of voer er een in)
```

2. Kopieer je publieke key:
```bash
cat ~/.ssh/id_ed25519.pub
```

3. Ga naar GitHub.com → Settings → SSH and GPG keys → New SSH key
4. Plak de key en klik "Add SSH key"

5. Verander remote naar SSH:
```bash
cd /Users/aminezerouali/Herd/mangaverse
git remote set-url origin git@github.com:amizer05/mangaverse.git
git push -u origin main
```

## 🚀 Push Commando

Zodra je authenticatie hebt ingesteld:

```bash
cd /Users/aminezerouali/Herd/mangaverse
git push -u origin main
```

## ✅ Verificatie

Na het pushen:
1. Ga naar https://github.com/amizer05/mangaverse
2. Controleer dat alle bestanden zichtbaar zijn
3. Controleer dat `vendor/` en `node_modules/` **NIET** zichtbaar zijn
4. Controleer dat `.env` **NIET** zichtbaar is (maar `.env.example` wel)

## 📋 Checklist voor Inzending

- [ ] Repository is PUBLIC
- [ ] Alle bestanden zijn gepusht
- [ ] `vendor/` en `node_modules/` zijn niet zichtbaar
- [ ] `.env` is niet zichtbaar
- [ ] README.md is compleet
- [ ] Repository link werkt: https://github.com/amizer05/mangaverse

## 🔗 Repository Link voor Inzending

```
https://github.com/amizer05/mangaverse
```

**Zorg ervoor dat de repository PUBLIC is!**






