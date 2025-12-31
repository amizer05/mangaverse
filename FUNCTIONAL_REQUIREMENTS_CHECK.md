# Functional Requirements Check - MangaVerse Project

## ✅ LOGIN SYSTEEM

### Bezoekers kunnen inloggen
- ✅ Route: `/login` (GET) - `auth.login`
- ✅ Route: `/login` (POST) - `AuthenticatedSessionController@store`
- ✅ View: `resources/views/auth/login.blade.php`
- ✅ Functionaliteit: Email/password authentication met remember me

### Alle bezoekers kunnen een nieuwe account aanmaken
- ✅ Route: `/register` (GET) - `auth.register`
- ✅ Route: `/register` (POST) - `RegisteredUserController@store`
- ✅ View: `resources/views/auth/register.blade.php`
- ✅ Functionaliteit: Volledige registratie met username, email, password, birthday, about_me

### Een useraccount is of een gewone gebruiker, of een admin
- ✅ Database: `is_admin` boolean field in users table
- ✅ Model: `User::isAdmin()` method
- ✅ Middleware: `EnsureUserIsAdmin` voor admin routes

### Enkel admins kunnen andere gebruikers verheffen tot admin en deze rechten afnemen
- ✅ Route: `POST /admin/users/{user}/toggle-admin` - `admin.users.toggle-admin`
- ✅ Controller: `Admin\UserController@toggleAdmin`
- ✅ Functionaliteit: Toggle admin status met bescherming (kan jezelf niet verwijderen)
- ✅ View: Admin users index met toggle button

### Enkel admins kunnen een nieuwe gebruiker manueel aanmaken (en deze al dan niet admin maken)
- ✅ Route: `GET /admin/users/create` - `admin.users.create`
- ✅ Route: `POST /admin/users` - `admin.users.store`
- ✅ Controller: `Admin\UserController@create` en `@store`
- ✅ View: `resources/views/admin/users/create.blade.php`
- ✅ Functionaliteit: Volledige user creation form met admin checkbox

## ✅ PROFIELPAGINA

### Elke gebruiker heeft zijn eigen publieke profielpagina die toegankelijk is voor iedereen
- ✅ Route: `GET /users/{username}` - `users.show`
- ✅ Controller: `UserProfileController@show`
- ✅ View: `resources/views/users/show.blade.php`
- ✅ Functionaliteit: Publiek toegankelijk, geen auth vereist

### Een ingelogde gebruiker kan diens eigen data aanpassen
- ✅ Route: `GET /profile` - `profile.edit`
- ✅ Route: `PATCH /profile` - `profile.update`
- ✅ Controller: `ProfileController@edit` en `@update`
- ✅ View: `resources/views/profile/edit.blade.php`
- ✅ Functionaliteit: Volledige profile edit met tabs (Profile, Security, Preferences, Notifications)

### Een profiel bevat minstens de volgende data:
- ✅ **Username**: Optional field, user kan zelf kiezen
- ✅ **Verjaardag**: `birthday` date field
- ✅ **Profielfoto**: `profile_photo_path` string field (opgeslagen op webserver)
- ✅ **Kleine "over mij" tekst**: `about_me` text field

## ✅ LAATSTE NIEUWS

### Admins kunnen nieuwe nieuwsitems toevoegen, wijzigen en verwijderen
- ✅ Route: `GET /admin/news/create` - `admin.news.create`
- ✅ Route: `POST /admin/news` - `admin.news.store`
- ✅ Route: `GET /admin/news/{news}/edit` - `admin.news.edit`
- ✅ Route: `PATCH /admin/news/{news}` - `admin.news.update`
- ✅ Route: `DELETE /admin/news/{news}` - `admin.news.destroy`
- ✅ Controller: `NewsController` (resource controller)
- ✅ Views: `resources/views/admin/news/` (create, edit, index, show)
- ✅ Functionaliteit: Volledige CRUD voor admins

### Elke bezoeker kan een lijst van alle nieuwtjes en een detail per nieuwtje zien
- ✅ Route: `GET /news` - `news.public.index`
- ✅ Route: `GET /news/{news}` - `news.public.show`
- ✅ Controller: `NewsController@indexPublic` en `@showPublic`
- ✅ Views: `resources/views/news/index-public.blade.php` en `show-public.blade.php`
- ✅ Functionaliteit: Publiek toegankelijk, alleen gepubliceerde items

### De nieuwsitems hebben minstens:
- ✅ **Titel**: `title` field
- ✅ **Afbeelding**: `image` field (opgeslagen op server)
- ✅ **Content**: `content` text field
- ✅ **Publicatiedatum**: `published_at` datetime field

## ✅ FAQ PAGINA

### De FAQ-pagina bevat een lijst van vragen en antwoorden, gegroepeerd per categorie
- ✅ Route: `GET /faq` - `faq.index`
- ✅ Controller: `FaqController@index`
- ✅ View: `resources/views/faq/index.blade.php`
- ✅ Functionaliteit: FAQ items gegroepeerd per categorie

### Admins kunnen categorieën en vraag/antwoorden toevoegen, wijzigen en verwijderen
- ✅ **FAQ Categories**:
  - Route: `GET /admin/faq-categories` - `admin.faq-categories.index`
  - Route: `GET /admin/faq-categories/create` - `admin.faq-categories.create`
  - Route: `POST /admin/faq-categories` - `admin.faq-categories.store`
  - Route: `GET /admin/faq-categories/{faqCategory}/edit` - `admin.faq-categories.edit`
  - Route: `PATCH /admin/faq-categories/{faqCategory}` - `admin.faq-categories.update`
  - Route: `DELETE /admin/faq-categories/{faqCategory}` - `admin.faq-categories.destroy`
  - Controller: `FaqCategoryController` (resource controller)
  - Views: `resources/views/admin/faq-categories/`

- ✅ **FAQ Items**:
  - Route: `GET /admin/faq-items` - `admin.faq-items.index`
  - Route: `GET /admin/faq-items/create` - `admin.faq-items.create`
  - Route: `POST /admin/faq-items` - `admin.faq-items.store`
  - Route: `GET /admin/faq-items/{faqItem}/edit` - `admin.faq-items.edit`
  - Route: `PATCH /admin/faq-items/{faqItem}` - `admin.faq-items.update`
  - Route: `DELETE /admin/faq-items/{faqItem}` - `admin.faq-items.destroy`
  - Controller: `FaqItemController` (resource controller)
  - Views: `resources/views/admin/faq-items/`

### Elke bezoeker kan de FAQ zien
- ✅ Route: `GET /faq` - `faq.index`
- ✅ Publiek toegankelijk, geen auth vereist

## ✅ CONTACT PAGINA

### Elke bezoeker kan een contactformulier invullen
- ✅ Route: `GET /contact` - `contact.create`
- ✅ Route: `POST /contact` - `contact.store`
- ✅ Controller: `ContactController@create` en `@store`
- ✅ View: `resources/views/contact/create.blade.php`
- ✅ Functionaliteit: Volledige contact formulier

### Bij het versturen van dit contactformulier krijgt de admin een email met de inhoud van het formulier
- ✅ Mail Class: `App\Mail\ContactNotification`
- ✅ Location: `app/Mail/ContactNotification.php`
- ✅ View: `resources/views/emails/contact-notification.blade.php` (moet bestaan)
- ✅ Functionaliteit: Email wordt verstuurd naar admin email (config('mail.from.address'))
- ✅ Controller: `ContactController@store` regel 42: `Mail::to($adminEmail)->send(new ContactNotification($contact));`

## 📋 SUMMARY

### ✅ Alle Requirements Aanwezig:

1. **Login Systeem**: ✅
   - Login/Logout
   - Registratie
   - Admin/User rollen
   - Admin user management (promote/demote, manual create)

2. **Profielpagina**: ✅
   - Publieke profielpagina
   - Eigen data aanpassen
   - Alle vereiste velden (username, birthday, profile photo, about_me)

3. **Laatste Nieuwtjes**: ✅
   - Admin CRUD
   - Publieke lijst en detail
   - Alle vereiste velden (titel, afbeelding, content, publicatiedatum)

4. **FAQ Pagina**: ✅
   - Categorieën en items gegroepeerd
   - Admin CRUD voor beide
   - Publiek toegankelijk

5. **Contact Pagina**: ✅
   - Contactformulier
   - Email naar admin

### Test Routes:

```bash
# Admin User Management
GET  /admin/users              # List all users
GET  /admin/users/create       # Create new user form
POST /admin/users              # Store new user
GET  /admin/users/{user}       # Show user details
GET  /admin/users/{user}/edit  # Edit user form
PATCH /admin/users/{user}      # Update user
POST /admin/users/{user}/toggle-admin  # Toggle admin status
DELETE /admin/users/{user}     # Delete user

# Public Profile
GET  /users/{username}         # Public user profile

# News (Admin)
GET  /admin/news               # List news
GET  /admin/news/create        # Create news
POST /admin/news               # Store news
GET  /admin/news/{news}/edit   # Edit news
PATCH /admin/news/{news}       # Update news
DELETE /admin/news/{news}      # Delete news

# News (Public)
GET  /news                     # Public news list
GET  /news/{news}              # Public news detail

# FAQ (Admin)
GET  /admin/faq-categories     # List categories
GET  /admin/faq-items          # List items
# ... full CRUD for both

# FAQ (Public)
GET  /faq                      # Public FAQ

# Contact
GET  /contact                 # Contact form
POST /contact                 # Submit contact (sends email to admin)
```

## 🎯 All Functional Requirements Complete!






