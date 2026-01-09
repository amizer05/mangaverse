#!/bin/bash

# MangaVerse - Push naar GitHub Script
# Dit script helpt je om je code naar GitHub te pushen

echo "🚀 MangaVerse - Push naar GitHub"
echo "================================"
echo ""

# Check of we in de juiste directory zijn
if [ ! -f "artisan" ]; then
    echo "❌ Error: Je bent niet in de mangaverse directory!"
    echo "   Ga naar: cd /Users/aminezerouali/Herd/mangaverse"
    exit 1
fi

# Check of remote is ingesteld
if ! git remote get-url origin > /dev/null 2>&1; then
    echo "❌ Error: Git remote is niet ingesteld!"
    exit 1
fi

echo "✅ Repository: $(git remote get-url origin)"
echo "✅ Branch: $(git branch --show-current)"
echo ""

# Check of er uncommitted changes zijn
if [ -n "$(git status --porcelain)" ]; then
    echo "⚠️  Er zijn uncommitted changes. Wil je deze committen? (y/n)"
    read -r response
    if [ "$response" = "y" ]; then
        git add .
        echo "📝 Commit message:"
        read -r commit_msg
        git commit -m "$commit_msg"
    fi
fi

echo ""
echo "🔐 Authenticatie nodig voor GitHub"
echo ""
echo "Je hebt 2 opties:"
echo ""
echo "OPTIE 1: Personal Access Token (Aanbevolen)"
echo "1. Ga naar: https://github.com/settings/tokens"
echo "2. Klik 'Generate new token (classic)'"
echo "3. Naam: 'MangaVerse Project'"
echo "4. Scope: vink 'repo' aan"
echo "5. Klik 'Generate token'"
echo "6. Kopieer de token"
echo ""
echo "OPTIE 2: GitHub CLI"
echo "1. Installeer: brew install gh"
echo "2. Login: gh auth login"
echo "3. Probeer opnieuw: ./push.sh"
echo ""
echo "Druk Enter om door te gaan met push (gebruik token als wachtwoord)..."
read -r

echo ""
echo "📤 Pushing naar GitHub..."
git push -u origin main

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ SUCCESS! Code is gepusht naar GitHub!"
    echo ""
    echo "🔗 Repository: https://github.com/amizer05/mangaverse"
    echo ""
    echo "📋 Verificatie checklist:"
    echo "   [ ] Ga naar de repository link hierboven"
    echo "   [ ] Controleer dat alle bestanden zichtbaar zijn"
    echo "   [ ] Controleer dat vendor/ en node_modules/ NIET zichtbaar zijn"
    echo "   [ ] Controleer dat .env NIET zichtbaar is (maar .env.example wel)"
    echo "   [ ] Controleer dat repository PUBLIC is"
else
    echo ""
    echo "❌ Push gefaald. Controleer je authenticatie."
    echo ""
    echo "💡 Tips:"
    echo "   - Gebruik een Personal Access Token als wachtwoord"
    echo "   - Of installeer GitHub CLI: brew install gh && gh auth login"
fi






