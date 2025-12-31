# Manga API Integration - MyAnimeList (Jikan API)

## Overview

The MangaVerse website now integrates with the **Jikan API** (MyAnimeList) to automatically fetch real manga data, cover images, descriptions, and other useful resources. This integration enhances the website by providing:

- ✅ Real manga cover images
- ✅ Detailed descriptions and synopsis
- ✅ Genre information
- ✅ Release dates
- ✅ Manga statistics
- ✅ Search functionality

## API Service

### MangaApiService (`app/Services/MangaApiService.php`)

This service handles all interactions with the Jikan API:

**Features:**
- Search manga by title
- Get manga details by MyAnimeList ID
- Get top/popular manga
- Download and store cover images
- Sync manga data to database
- Cache API responses (24 hours)

**Methods:**
- `searchManga(string $query, int $limit)` - Search manga
- `getMangaById(int $malId)` - Get full manga details
- `getTopManga(int $limit, string $type)` - Get top manga
- `downloadCoverImage(string $imageUrl, string $slug)` - Download cover
- `syncMangaFromApi(array $apiData, ?Manga $manga)` - Sync to database
- `findAndSyncManga(string $title)` - Find and sync by title

## Usage

### 1. Admin Interface

#### Sync from Admin Panel
1. Go to `/admin/mangas`
2. Click "Sync from API" button
3. Search for manga by title
4. Click "Sync to Database" on any result
5. Manga will be added with cover image and all details

#### Import when Creating
1. Go to `/admin/mangas/create`
2. Click "Search API" button
3. Search for manga
4. Click "Use This Data" to auto-fill the form
5. Submit the form

### 2. Command Line

#### Sync by Title
```bash
php artisan manga:sync --title="One Piece"
```

#### Sync Top Manga
```bash
php artisan manga:sync --top --limit=20
```

#### Update Existing Manga
```bash
php artisan manga:sync --title="Naruto" --update
```

### 3. API Endpoints

#### Public Endpoints

**Search Manga**
```http
GET /api/v1/manga-api/search?q=one+piece&limit=10
```

**Get Top Manga**
```http
GET /api/v1/manga-api/top?limit=20&type=manga
```

**Get Manga Details**
```http
GET /api/v1/manga-api/details?mal_id=13
```

**Get Manga Statistics**
```http
GET /api/v1/manga-api/stats?mal_id=13
```

#### Authenticated Endpoints

**Sync Manga to Database**
```http
POST /api/v1/manga-api/sync
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "One Piece"
}
// OR
{
  "mal_id": 13
}
```

## How It Works

### 1. Search Process
1. User searches for manga title
2. Service queries Jikan API
3. Results are cached for 24 hours
4. User selects manga to sync

### 2. Sync Process
1. Service fetches full manga details from Jikan API
2. Downloads cover image from MyAnimeList
3. Stores image in `storage/app/public/manga-covers/`
4. Creates/updates manga record in database
5. Maps API data to database fields:
   - `title` ← API title
   - `slug` ← Generated from title
   - `description` ← API synopsis
   - `genre` ← First genre from API
   - `release_date` ← API published date
   - `cover_image` ← Downloaded image path

### 3. Caching
- All API responses are cached for 24 hours
- Reduces API calls and improves performance
- Cache keys: `manga_search_{query}`, `manga_{mal_id}`, etc.

## Benefits

### For Admins
- ✅ No need to manually upload cover images
- ✅ Automatic data enrichment
- ✅ Search and import popular manga quickly
- ✅ Always up-to-date information

### For Users
- ✅ Real, high-quality cover images
- ✅ Detailed descriptions
- ✅ Accurate release dates
- ✅ Genre information

## Rate Limiting

Jikan API has rate limits:
- **3 requests per second**
- **2 requests per second** for authenticated requests

The service includes:
- Automatic rate limiting delays (0.5 seconds between requests)
- Caching to minimize API calls
- Error handling for rate limit errors

## Example API Response

```json
{
  "mal_id": 13,
  "title": "One Piece",
  "title_english": "One Piece",
  "title_japanese": "ワンピース",
  "synopsis": "Monkey D. Luffy wants to become the King of all pirates...",
  "images": {
    "jpg": {
      "image_url": "https://cdn.myanimelist.net/images/manga/2/253146l.jpg",
      "small_image_url": "https://cdn.myanimelist.net/images/manga/2/253146s.jpg",
      "large_image_url": "https://cdn.myanimelist.net/images/manga/2/253146l.jpg"
    }
  },
  "genres": [
    {"mal_id": 1, "name": "Action"},
    {"mal_id": 2, "name": "Adventure"}
  ],
  "published": {
    "from": "1997-07-22T00:00:00+00:00",
    "to": null
  },
  "score": 9.78,
  "scored_by": 1234567,
  "rank": 1,
  "popularity": 1
}
```

## Database Integration

The API integration is fully synchronized with your database:
- Uses the same `mangas` table
- Same models and relationships
- Same validation rules
- Works with existing chapters and favorites

## Testing

### Test Search
```bash
curl "http://localhost/api/v1/manga-api/search?q=one+piece"
```

### Test Sync (requires auth)
```bash
# First login to get token
curl -X POST http://localhost/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@ehb.be","password":"Password!321"}'

# Then sync
curl -X POST http://localhost/api/v1/manga-api/sync \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"One Piece"}'
```

## Troubleshooting

### Images Not Downloading
- Check `storage/app/public` permissions
- Ensure `php artisan storage:link` is run
- Check disk space

### API Rate Limits
- Wait a few seconds between requests
- Use caching (already implemented)
- Consider upgrading to authenticated API if needed

### No Results Found
- Try different search terms
- Check if manga exists on MyAnimeList
- Verify API is accessible

## Future Enhancements

Possible additions:
- Auto-sync popular manga daily
- Background job processing
- Multiple API sources
- Chapter information from API
- Author/artist information
- Related manga suggestions






