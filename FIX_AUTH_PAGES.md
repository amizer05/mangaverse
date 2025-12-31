# Fix Login & Registratie Pagina's - CSS Loading

## Probleem
De login en registratie pagina's tonen een witte achtergrond in plaats van het donkere gradient design.

## Oplossing

### Stap 1: Start Vite Dev Server
```bash
npm run dev
```

### Stap 2: Hard Refresh Browser
- **Windows/Linux**: `Ctrl + Shift + R`
- **Mac**: `Cmd + Shift + R`

### Stap 3: Clear Browser Cache
1. Open Developer Tools (F12)
2. Rechtsklik op de refresh button
3. Selecteer "Empty Cache and Hard Reload"

## Code Status
✅ Alle code is correct geïmplementeerd:
- Donkere gradient achtergrond: `bg-gradient-to-b from-gray-900 via-purple-900 to-gray-900`
- Donkere form cards: `bg-gray-800/50 backdrop-blur-xl`
- Donkere inputs: `bg-gray-900/50`
- Consistent met dashboard en andere pagina's

## Als het nog steeds niet werkt:

1. **Check of Vite draait:**
   ```bash
   npm run dev
   ```

2. **Rebuild assets:**
   ```bash
   npm run build
   ```

3. **Clear Laravel cache:**
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

4. **Check browser console voor errors:**
   - Open Developer Tools (F12)
   - Kijk naar Console tab voor errors
   - Kijk naar Network tab om te zien of CSS wordt geladen

