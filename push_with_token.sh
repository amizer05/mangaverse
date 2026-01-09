#!/bin/bash

# Push script met token
TOKEN="JE_TOKEN_HIER"
USERNAME="amizer05"
REPO="mangaverse"

cd /Users/aminezerouali/Herd/mangaverse

echo "🚀 Pushing naar GitHub..."

# Gebruik token in URL (tijdelijk)
git remote set-url origin https://${USERNAME}:${TOKEN}@github.com/${USERNAME}/${REPO}.git

# Push
git push -u origin main

# Verwijder token uit URL (veiligheid)
git remote set-url origin https://github.com/${USERNAME}/${REPO}.git

echo ""
if [ $? -eq 0 ]; then
    echo "✅ SUCCESS! Code is gepusht naar GitHub!"
    echo "🔗 https://github.com/${USERNAME}/${REPO}"
else
    echo "❌ Push gefaald. Controleer:"
    echo "   1. Token heeft 'repo' scope"
    echo "   2. Token is niet verlopen"
    echo "   3. Repository bestaat en is toegankelijk"
fi

