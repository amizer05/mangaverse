# Hoe CSS Problemen Oplossen - Stap voor Stap

## Stap 1: Start Vite Dev Server

### In Terminal:
```bash
cd /Users/aminezerouali/Herd/mangaverse
npm run dev
```

Je zou iets moeten zien zoals:
```
VITE v7.2.6  ready in 500 ms

➜  Local:   http://localhost:5173/
➜  Network: use --host to expose
```

**Laat deze terminal open staan!** De dev server moet blijven draaien.

---

## Stap 2: Hard Refresh in Browser

### Chrome/Edge (Windows/Linux):
1. Open je browser
2. Ga naar `http://127.0.0.1:8001/login` of `http://127.0.0.1:8001/register`
3. Druk op **`Ctrl + Shift + R`** (of **`Ctrl + F5`**)

### Chrome/Edge (Mac):
1. Open je browser
2. Ga naar `http://127.0.0.1:8001/login` of `http://127.0.0.1:8001/register`
3. Druk op **`Cmd + Shift + R`**

### Firefox:
- **Windows/Linux**: `Ctrl + Shift + R` of `Ctrl + F5`
- **Mac**: `Cmd + Shift + R`

### Safari (Mac):
- **Cmd + Option + R**

---

## Stap 3: Clear Browser Cache (Als Hard Refresh niet werkt)

### Chrome/Edge:
1. Druk op **F12** om Developer Tools te openen
2. Rechtsklik op de **refresh button** (naast de adresbalk)
3. Selecteer **"Empty Cache and Hard Reload"**

### Of via Settings:
1. Druk op **F12** (Developer Tools)
2. Ga naar **Network** tab
3. Vink **"Disable cache"** aan
4. Herlaad de pagina

---

## Stap 4: Check of CSS wordt geladen

1. Druk op **F12** om Developer Tools te openen
2. Ga naar de **Network** tab
3. Herlaad de pagina
4. Zoek naar bestanden met `.css` extensie
5. Check of ze **200 OK** status hebben (groen)

Als je **404** of **Failed to load** ziet, dan wordt de CSS niet gevonden.

---

## Stap 5: Als het nog steeds niet werkt

### Rebuild Assets:
```bash
npm run build
```

### Clear Laravel Cache:
```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

### Check Browser Console voor Errors:
1. Druk op **F12**
2. Ga naar **Console** tab
3. Kijk naar rode errors
4. Deel deze errors als je hulp nodig hebt

---

## Snelle Checklist:

- [ ] Vite dev server draait (`npm run dev`)
- [ ] Hard refresh gedaan (`Ctrl+Shift+R` of `Cmd+Shift+R`)
- [ ] Browser cache geleegd
- [ ] CSS bestanden worden geladen (check Network tab)
- [ ] Geen errors in Console tab

---

## Troubleshooting

### Probleem: "npm run dev" geeft error
**Oplossing:**
```bash
npm install
npm run dev
```

### Probleem: Port 5173 is al in gebruik
**Oplossing:**
```bash
# Stop andere processen of gebruik andere port
npm run dev -- --port 5174
```

### Probleem: CSS wordt nog steeds niet geladen
**Oplossing:**
1. Check of Vite draait (zie terminal output)
2. Check of Laravel server draait (`php artisan serve`)
3. Check browser console voor errors
4. Probeer incognito/private browsing mode

---

## Verwacht Resultaat

Na deze stappen zou je moeten zien:
- ✅ Donkere gradient achtergrond (grijs naar paars naar grijs)
- ✅ Donkere form cards met transparantie
- ✅ Donkere input velden
- ✅ Paarse/pink gradient buttons
- ✅ Consistent met dashboard design

