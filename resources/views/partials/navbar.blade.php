<nav class="bg-gradient-to-r from-indigo-600 to-blue-600 shadow-xl">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-3">
            <!-- Logo et nom de l'application -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('home') }}" class="flex items-center"> <!-- Modifié pour pointer vers la home -->
                    <div class="bg-white p-2 rounded-lg shadow-sm">
                        <i class="fas fa-tasks text-indigo-600 text-xl"></i>
                    </div>
                    <span class="ml-2 text-white text-xl font-bold hidden sm:inline">TaskManager Pro</span>
                </a>
            </div>

            <!-- Navigation principale -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Bouton Accueil ajouté ici -->
                
                
                <a href="{{ route('taches.index') }}" class="px-3 py-2 text-white hover:bg-indigo-700 rounded-lg transition flex items-center">
                    <i class="fas fa-list-check mr-2"></i> Accueil
                </a>
                @if(auth()->user()->roles->contains('name', 'admin'))
                <a href="{{ route('users.index') }}" class="px-3 py-2 text-white hover:bg-indigo-700 rounded-lg transition flex items-center">
                    <i class="fas fa-users-cog mr-2"></i> Utilisateurs
                </a>
                @endif
                <a href="{{ route('taches.futures') }}" class="px-3 py-2 text-white hover:bg-indigo-700 rounded-lg transition flex items-center">
                    <i clas419
Page Expired
 quand j'appuis sur déconnection j'obtient (
419
Page Expireds="fas fa-calendar-alt mr-2"></i> Futures
                </a>
                <a href="{{ route('taches.accomplies') }}" class="px-3 py-2 text-white hover:bg-indigo-700 rounded-lg transition flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Accomplies
                </a>
            </div>

            <!-- Menu utilisateur -->
            <div class="flex items-center space-x-4">
                <!-- Dropdown utilisateur -->
                <div class="relative">
                    <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                        <div class="w-9 h-9 rounded-full bg-indigo-800 flex items-center justify-center text-white font-semibold shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="text-white font-medium hidden lg:inline">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-white text-xs hidden lg:inline"></i>
                    </button>
                    
                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-xl py-1 z-50 border border-gray-100">
                        <!-- En-tête du profil -->
                        <div class="px-4 py-3 border-b">
                            <div class="font-medium text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <!-- Lien vers le profil -->
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                            <i class="fas fa-user-circle mr-2 text-indigo-500"></i> Mon profil
                        </a>
                        
                        <!-- Lien pour modifier le profil -->
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                            <i class="fas fa-cog mr-2 text-blue-500"></i> Paramètres
                        </a>
                        
                        <!-- Séparateur -->
                        <div class="border-t border-gray-100 my-1"></div>
                        
                        <!-- Déconnexion -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                <i class="fas fa-sign-out-alt mr-2 text-red-500"></i> Déconnexion
                            </button>
                        </form>
                        
                        <!-- Suppression de compte -->
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')">
                                <i class="fas fa-trash-alt mr-2"></i> Supprimer mon compte
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Bouton menu mobile -->
                <button id="mobileMenuButton" class="md:hidden text-white p-2 rounded-full hover:bg-indigo-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Menu mobile -->
        <div id="mobileMenu" class="hidden md:hidden pb-4 pt-2">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-white hover:bg-indigo-700 rounded-lg transition flex items-center">
                <i class="fas fa-home mr-3"></i> Accueil
            </a>
            <a href="{{ route('taches.index') }}" class="block px-4 py-2 text-white hover:bg-indigo-700 rounded-lg transition flex items-center">
                <i class="fas fa-list-check mr-3"></i> Aujourd'hui
            </a>
            <a href="{{ route('taches.futures') }}" class="block px-4 py-2 text-white hover:bg-indigo-700 rounded-lg transition flex items-center">
                <i class="fas fa-calendar-alt mr-3"></i> Futures
            </a>
            <a href="{{ route('taches.accomplies') }}" class="block px-4 py-2 text-white hover:bg-indigo-700 rounded-lg transition flex items-center">
                <i class="fas fa-check-circle mr-3"></i> Accomplies
            </a>
            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-white hover:bg-indigo-700 rounded-lg transition flex items-center">
                <i class="fas fa-user-circle mr-3"></i> Mon profil
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2">
                @csrf
                <button type="submit" class="text-white hover:text-indigo-200 w-full text-left flex items-center">
                    <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    // Gestion du menu utilisateur
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');
    
    userMenuButton.addEventListener('click', (e) => {
        e.stopPropagation();
        userMenu.classList.toggle('hidden');
    });
    
    // Gestion du menu mobile
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    
    mobileMenuButton.addEventListener('click', (e) => {
        e.stopPropagation();
        mobileMenu.classList.toggle('hidden');
    });
    
    // Fermer les menus quand on clique ailleurs
    document.addEventListener('click', () => {
        userMenu.classList.add('hidden');
    });
</script>
@endpush