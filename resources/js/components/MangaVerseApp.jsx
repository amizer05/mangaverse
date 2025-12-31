import React, { useState } from 'react';
// I used lucide-react for icons because it's easy to use
import { User, Mail, Lock, Calendar, BookOpen, Star, TrendingUp, Clock, Settings, LogOut, Eye, EyeOff } from 'lucide-react';

function MangaVerseApp() {
    // State for the current page (login, register, or dashboard)
    const [currentPage, setCurrentPage] = useState('login');

    // States for password visibility
    const [showPassword, setShowPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);

    // User state
    const [user, setUser] = useState(null);

    // Form states
    const [loginData, setLoginData] = useState({
        email: '',
        password: '',
        remember: false
    });

    const [registerData, setRegisterData] = useState({
        name: '',
        username: '',
        email: '',
        birthday: '',
        about: '',
        password: '',
        confirmPassword: ''
    });

    // Error messages
    const [errors, setErrors] = useState({});

    // Function to validate email format
    function validateEmail(email) {
        // Regular expression for email validation
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Handle login form submit
    function handleLogin(e) {
        e.preventDefault();
        let newErrors = {};
        let isValid = true;

        // Check email
        if (loginData.email === '') {
            newErrors.email = 'Email is verplicht';
            isValid = false;
        } else if (validateEmail(loginData.email) === false) {
            newErrors.email = 'Ongeldig email formaat';
            isValid = false;
        }

        // Check password
        if (loginData.password === '') {
            newErrors.password = 'Wachtwoord is verplicht';
            isValid = false;
        }

        setErrors(newErrors);

        // If there are no errors, log the user in
        if (isValid) {
            // Set dummy user data for demo
            setUser({
                name: 'Demo User',
                email: loginData.email
            });
            setCurrentPage('dashboard');
        }
    }

    // Handle register form submit
    function handleRegister(e) {
        e.preventDefault();
        let newErrors = {};
        let isValid = true;

        // Validate name
        if (registerData.name === '') {
            newErrors.name = 'Naam is verplicht';
            isValid = false;
        }

        // Validate email
        if (registerData.email === '') {
            newErrors.email = 'Email is verplicht';
            isValid = false;
        } else {
            if (validateEmail(registerData.email) === false) {
                newErrors.email = 'Ongeldig email formaat';
                isValid = false;
            }
        }

        // Validate password
        if (registerData.password === '') {
            newErrors.password = 'Wachtwoord is verplicht';
            isValid = false;
        } else if (registerData.password.length < 8) {
            newErrors.password = 'Wachtwoord moet minstens 8 tekens lang zijn';
            isValid = false;
        }

        // Check if passwords match
        if (registerData.password !== registerData.confirmPassword) {
            newErrors.confirmPassword = 'Wachtwoorden komen niet overeen';
            isValid = false;
        }

        setErrors(newErrors);

        if (isValid) {
            setUser({
                name: registerData.name,
                email: registerData.email
            });
            setCurrentPage('dashboard');
        }
    }

    // Logout function
    function handleLogout() {
        setUser(null);
        setCurrentPage('login');
        // Reset all forms
        setLoginData({
            email: '',
            password: '',
            remember: false
        });
        setRegisterData({
            name: '',
            username: '',
            email: '',
            birthday: '',
            about: '',
            password: '',
            confirmPassword: ''
        });
        setErrors({});
    }

    // Helper function to update login data
    function updateLoginData(field, value) {
        setLoginData({
            ...loginData,
            [field]: value
        });
    }

    // Helper function to update register data
    const updateRegisterData = (field, value) => {
        setRegisterData({
            ...registerData,
            [field]: value
        });
    };

    // Dummy data for the dashboard
    const mangaList = [
        { id: 1, title: 'One Piece', chapter: 1095, rating: 4.9, cover: '🏴‍☠️' },
        { id: 2, title: 'Attack on Titan', chapter: 139, rating: 4.8, cover: '⚔️' },
        { id: 3, title: 'My Hero Academia', chapter: 405, rating: 4.7, cover: '🦸' },
        { id: 4, title: 'Jujutsu Kaisen', chapter: 245, rating: 4.8, cover: '👻' },
    ];

    const recentlyRead = [
        { title: 'Demon Slayer', chapter: 45, progress: 65 },
        { title: 'Tokyo Ghoul', chapter: 28, progress: 40 },
        { title: 'Naruto', chapter: 156, progress: 85 },
    ];

    // If user is logged in, show the dashboard
    if (currentPage === 'dashboard') {
        return (
            <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
                {/* Header section */}
                <header className="bg-slate-900/80 backdrop-blur-sm border-b border-purple-500/30">
                    <div className="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                        <div className="flex items-center gap-3">
                            <a href="/" className="flex items-center gap-3 hover:opacity-80 transition-opacity">
                                <div className="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center font-bold text-white">
                                    M
                                </div>
                                <span className="text-2xl font-bold text-white">MangaVerse</span>
                            </a>
                        </div>
                        <div className="flex items-center gap-4">
                            <button className="p-2 hover:bg-purple-500/20 rounded-lg transition">
                                <Settings className="w-5 h-5 text-purple-300" />
                            </button>
                            <div className="flex items-center gap-3 bg-slate-800/50 px-4 py-2 rounded-lg">
                                <div className="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center">
                                    <User className="w-5 h-5 text-white" />
                                </div>
                                <span className="text-white font-medium">{user && user.name}</span>
                            </div>
                            <button
                                onClick={handleLogout}
                                className="p-2 hover:bg-red-500/20 rounded-lg transition text-red-400"
                            >
                                <LogOut className="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </header>

                {/* Main Dashboard Content */}
                <div className="max-w-7xl mx-auto px-6 py-8">
                    {/* Stats Cards Row */}
                    <div className="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div className="bg-gradient-to-br from-purple-500/20 to-purple-600/20 backdrop-blur-sm border border-purple-500/30 rounded-xl p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-purple-300 text-sm">Totaal Gelezen</p>
                                    <p className="text-3xl font-bold text-white mt-1">47</p>
                                </div>
                                <BookOpen className="w-10 h-10 text-purple-400" />
                            </div>
                        </div>

                        <div className="bg-gradient-to-br from-pink-500/20 to-pink-600/20 backdrop-blur-sm border border-pink-500/30 rounded-xl p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-pink-300 text-sm">Favorieten</p>
                                    <p className="text-3xl font-bold text-white mt-1">23</p>
                                </div>
                                <Star className="w-10 h-10 text-pink-400" />
                            </div>
                        </div>

                        <div className="bg-gradient-to-br from-blue-500/20 to-blue-600/20 backdrop-blur-sm border border-blue-500/30 rounded-xl p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-blue-300 text-sm">Deze Week</p>
                                    <p className="text-3xl font-bold text-white mt-1">12</p>
                                </div>
                                <TrendingUp className="w-10 h-10 text-blue-400" />
                            </div>
                        </div>

                        <div className="bg-gradient-to-br from-orange-500/20 to-orange-600/20 backdrop-blur-sm border border-orange-500/30 rounded-xl p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-orange-300 text-sm">Leestijd</p>
                                    <p className="text-3xl font-bold text-white mt-1">34u</p>
                                </div>
                                <Clock className="w-10 h-10 text-orange-400" />
                            </div>
                        </div>
                    </div>

                    {/* Recently Read Section */}
                    <div className="mb-8">
                        <h2 className="text-2xl font-bold text-white mb-4">Recent Gelezen</h2>
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {recentlyRead.map((manga, idx) => (
                                <div key={idx} className="bg-slate-800/50 backdrop-blur-sm border border-purple-500/30 rounded-xl p-6 hover:border-purple-500/50 transition">
                                    <h3 className="text-white font-semibold mb-2">{manga.title}</h3>
                                    <p className="text-purple-300 text-sm mb-3">Hoofdstuk {manga.chapter}</p>
                                    <div className="w-full bg-slate-700 rounded-full h-2">
                                        <div
                                            className="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all"
                                            style={{ width: `${manga.progress}%` }}
                                        />
                                    </div>
                                    <p className="text-purple-300 text-xs mt-2">{manga.progress}% voltooid</p>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Popular Manga Grid */}
                    <div>
                        <h2 className="text-2xl font-bold text-white mb-4">Populaire Manga</h2>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            {mangaList.map((manga) => (
                                <div key={manga.id} className="bg-slate-800/50 backdrop-blur-sm border border-purple-500/30 rounded-xl p-6 hover:border-purple-500/50 transition cursor-pointer group">
                                    <div className="text-6xl mb-4 transform group-hover:scale-110 transition">{manga.cover}</div>
                                    <h3 className="text-white font-semibold mb-2">{manga.title}</h3>
                                    <div className="flex items-center justify-between text-sm">
                                        <span className="text-purple-300">Ch. {manga.chapter}</span>
                                        <div className="flex items-center gap-1">
                                            <Star className="w-4 h-4 text-yellow-400 fill-yellow-400" />
                                            <span className="text-white">{manga.rating}</span>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    // Login / Register View
    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center p-6">
            <div className="w-full max-w-md">
                {/* Back to Home Button */}
                <div className="absolute top-6 left-6">
                    <a href="/" className="flex items-center gap-2 text-purple-300 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Terug naar Home
                    </a>
                </div>

                {/* Logo */}
                <div className="text-center mb-8">
                    <a href="/" className="inline-block hover:opacity-80 transition-opacity">
                        <div className="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl mb-4 shadow-lg shadow-purple-500/50">
                            <span className="text-3xl font-bold text-white">M</span>
                        </div>
                        <h1 className="text-4xl font-bold text-white mb-2">MangaVerse</h1>
                        <p className="text-purple-300">Jouw manga universum</p>
                    </a>
                </div>

                {/* Form Card Container */}
                <div className="bg-slate-800/50 backdrop-blur-xl border border-purple-500/30 rounded-2xl shadow-2xl p-8">
                    {currentPage === 'login' ? (
                        <form onSubmit={handleLogin}>
                            <h2 className="text-2xl font-bold text-white mb-6">Inloggen</h2>

                            {/* Email Input */}
                            <div className="mb-4">
                                <label className="block text-purple-300 text-sm mb-2">Email</label>
                                <div className="relative">
                                    <Mail className="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" />
                                    <input
                                        type="email"
                                        value={loginData.email}
                                        onChange={(e) => updateLoginData('email', e.target.value)}
                                        className="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white focus:border-purple-500 focus:outline-none transition"
                                        placeholder="jouw@email.com"
                                    />
                                </div>
                                {errors.email && <p className="text-red-400 text-xs mt-1">{errors.email}</p>}
                            </div>

                            {/* Password Input */}
                            <div className="mb-4">
                                <label className="block text-purple-300 text-sm mb-2">Wachtwoord</label>
                                <div className="relative">
                                    <Lock className="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" />
                                    <input
                                        type={showPassword ? "text" : "password"}
                                        value={loginData.password}
                                        onChange={(e) => updateLoginData('password', e.target.value)}
                                        className="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg pl-11 pr-11 py-3 text-white focus:border-purple-500 focus:outline-none transition"
                                        placeholder="••••••••"
                                    />
                                    <button
                                        type="button"
                                        onClick={() => setShowPassword(!showPassword)}
                                        className="absolute right-3 top-1/2 transform -translate-y-1/2 text-purple-400 hover:text-purple-300"
                                    >
                                        {showPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
                                    </button>
                                </div>
                                {errors.password && <p className="text-red-400 text-xs mt-1">{errors.password}</p>}
                            </div>

                            <div className="flex items-center justify-between mb-6">
                                <label className="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        checked={loginData.remember}
                                        onChange={(e) => updateLoginData('remember', e.target.checked)}
                                        className="w-4 h-4 rounded border-purple-500/30 bg-slate-900/50 text-purple-500 focus:ring-purple-500"
                                    />
                                    <span className="text-purple-300 text-sm">Onthoud mij</span>
                                </label>
                                <button type="button" className="text-purple-400 text-sm hover:text-purple-300 transition">
                                    Wachtwoord vergeten?
                                </button>
                            </div>

                            <button
                                type="submit"
                                className="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold py-3 rounded-lg hover:from-purple-600 hover:to-pink-600 transition transform hover:scale-105 shadow-lg shadow-purple-500/50"
                            >
                                Inloggen
                            </button>

                            <p className="text-center text-purple-300 mt-6">
                                Nog geen account?{' '}
                                <button
                                    type="button"
                                    onClick={() => {
                                        setCurrentPage('register');
                                        setErrors({});
                                    }}
                                    className="text-purple-400 font-semibold hover:text-purple-300 transition"
                                >
                                    Registreer nu
                                </button>
                            </p>
                        </form>
                    ) : (
                        <form onSubmit={handleRegister} className="max-h-[70vh] overflow-y-auto pr-2">
                            <h2 className="text-2xl font-bold text-white mb-6">Registreren</h2>

                            <div className="mb-4">
                                <label className="block text-purple-300 text-sm mb-2">Naam *</label>
                                <div className="relative">
                                    <User className="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" />
                                    <input
                                        type="text"
                                        value={registerData.name}
                                        onChange={(e) => updateRegisterData('name', e.target.value)}
                                        className="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white focus:border-purple-500 focus:outline-none transition"
                                        placeholder="Jouw naam"
                                    />
                                </div>
                                {errors.name && <p className="text-red-400 text-xs mt-1">{errors.name}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-purple-300 text-sm mb-2">Gebruikersnaam (optioneel)</label>
                                <div className="relative">
                                    <User className="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" />
                                    <input
                                        type="text"
                                        value={registerData.username}
                                        onChange={(e) => updateRegisterData('username', e.target.value)}
                                        className="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white focus:border-purple-500 focus:outline-none transition"
                                        placeholder="gebruikersnaam"
                                    />
                                </div>
                                <p className="text-purple-400 text-xs mt-1">Voor je publieke profiel URL</p>
                            </div>

                            <div className="mb-4">
                                <label className="block text-purple-300 text-sm mb-2">Email *</label>
                                <div className="relative">
                                    <Mail className="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" />
                                    <input
                                        type="email"
                                        value={registerData.email}
                                        onChange={(e) => updateRegisterData('email', e.target.value)}
                                        className="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white focus:border-purple-500 focus:outline-none transition"
                                        placeholder="jouw@email.com"
                                    />
                                </div>
                                {errors.email && <p className="text-red-400 text-xs mt-1">{errors.email}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-purple-300 text-sm mb-2">Geboortedatum</label>
                                <div className="relative">
                                    <Calendar className="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" />
                                    <input
                                        type="date"
                                        value={registerData.birthday}
                                        onChange={(e) => updateRegisterData('birthday', e.target.value)}
                                        className="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white focus:border-purple-500 focus:outline-none transition"
                                    />
                                </div>
                            </div>

                            <div className="mb-4">
                                <label className="block text-purple-300 text-sm mb-2">Over Mij</label>
                                <textarea
                                    value={registerData.about}
                                    onChange={(e) => updateRegisterData('about', e.target.value)}
                                    rows="3"
                                    className="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg px-4 py-3 text-white focus:border-purple-500 focus:outline-none transition resize-none"
                                    placeholder="Vertel iets over jezelf..."
                                />
                            </div>

                            <div className="mb-4">
                                <label className="block text-purple-300 text-sm mb-2">Wachtwoord *</label>
                                <div className="relative">
                                    <Lock className="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" />
                                    <input
                                        type="text"
                                        value={registerData.password}
                                        onChange={(e) => updateRegisterData('password', e.target.value)}
                                        className="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg pl-11 pr-11 py-3 text-white focus:border-purple-500 focus:outline-none transition"
                                        placeholder="••••••••"
                                    />
                                    <button
                                        type="button"
                                        onClick={() => setShowPassword(!showPassword)}
                                        className="absolute right-3 top-1/2 transform -translate-y-1/2 text-purple-400 hover:text-purple-300"
                                    >
                                        {showPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
                                    </button>
                                </div>
                                {errors.password && <p className="text-red-400 text-xs mt-1">{errors.password}</p>}
                            </div>

                            <div className="mb-6">
                                <label className="block text-purple-300 text-sm mb-2">Bevestig Wachtwoord *</label>
                                <div className="relative">
                                    <Lock className="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" />
                                    <input
                                        type={showConfirmPassword ? "text" : "password"}
                                        value={registerData.confirmPassword}
                                        onChange={(e) => updateRegisterData('confirmPassword', e.target.value)}
                                        className="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg pl-11 pr-11 py-3 text-white focus:border-purple-500 focus:outline-none transition"
                                        placeholder="••••••••"
                                    />
                                    <button
                                        type="button"
                                        onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                                        className="absolute right-3 top-1/2 transform -translate-y-1/2 text-purple-400 hover:text-purple-300"
                                    >
                                        {showConfirmPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
                                    </button>
                                </div>
                                {errors.confirmPassword && <p className="text-red-400 text-xs mt-1">{errors.confirmPassword}</p>}
                            </div>

                            <button
                                type="submit"
                                className="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold py-3 rounded-lg hover:from-purple-600 hover:to-pink-600 transition transform hover:scale-105 shadow-lg shadow-purple-500/50"
                            >
                                Registreren
                            </button>

                            <p className="text-center text-purple-300 mt-6">
                                Al een account?{' '}
                                <button
                                    type="button"
                                    onClick={() => {
                                        setCurrentPage('login');
                                        setErrors({});
                                    }}
                                    className="text-purple-400 font-semibold hover:text-purple-300 transition"
                                >
                                    Log hier in
                                </button>
                            </p>
                        </form>
                    )}
                </div>
            </div>
        </div>
    );
}

export default MangaVerseApp;
