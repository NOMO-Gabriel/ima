@extends('layouts.app')

@section('title', 'Modifier le Livre')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5 transition-colors duration-300" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-colors duration-300"
                   :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.books.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-300 md:ml-2"
                       :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                        Catalogue des Livres
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium md:ml-2"
                          :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                        Modifier le Livre
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="shadow-md rounded-lg p-6 mb-8 transition-colors duration-300"
         :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
        <!-- En-tête avec titre -->
        <div class="flex items-center mb-8">
            <div class="w-10 h-10 rounded-full bg-[#4CA3DD] flex items-center justify-center text-white mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold transition-colors duration-300"
                    :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                    Modifier le Livre
                </h1>
                <p class="text-sm transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                    {{ $book->title }} - ID: {{ $book->id }}
                </p>
            </div>
        </div>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div id="alert-errors" class="flex p-4 mb-6 border-l-4 border-red-500 transition-colors duration-300"
                 :class="{ 'bg-gray-800 text-red-400': darkMode, 'bg-red-50 text-red-800': !darkMode }"
                 role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3">
                    <h3 class="text-lg font-medium mb-2">Veuillez corriger les erreurs suivantes :</h3>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 p-1.5 inline-flex h-8 w-8 rounded-lg focus:ring-2 focus:ring-red-400 transition-colors duration-300"
                        :class="{ 'bg-gray-800 text-red-400 hover:bg-gray-700': darkMode, 'bg-red-50 text-red-500': !darkMode }"
                        data-dismiss-target="#alert-errors" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('admin.books.update', ['locale' => app()->getLocale(), 'book' => $book->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Colonne gauche -->
                <div class="space-y-6">
                    <!-- Titre du livre -->
                    <div class="form-group">
                        <label for="title" class="block text-sm font-medium mb-2 transition-colors duration-300"
                               :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Titre <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                               class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                               :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }" />
                        @error('title')
                        <p class="mt-2 text-sm transition-colors duration-300"
                           :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Auteur -->
                    <div class="form-group">
                        <label for="author" class="block text-sm font-medium mb-2 transition-colors duration-300"
                               :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Auteur
                            </span>
                        </label>
                        <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}"
                               class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                               :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }" />
                        @error('author')
                        <p class="mt-2 text-sm transition-colors duration-300"
                           :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Éditeur -->
                    <div class="form-group">
                        <label for="publisher" class="block text-sm font-medium mb-2 transition-colors duration-300"
                               :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Éditeur
                            </span>
                        </label>
                        <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}"
                               class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                               :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }" />
                        @error('publisher')
                        <p class="mt-2 text-sm transition-colors duration-300"
                           :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Année de publication et ISBN -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="publicationYear" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Année
                                </span>
                            </label>
                            <input type="number" name="publicationYear" id="publicationYear" value="{{ old('publicationYear', $book->publicationYear) }}" min="1900" max="{{ date('Y') + 1 }}"
                                   class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                                   :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }" />
                            @error('quantity')
                            <p class="mt-2 text-sm transition-colors duration-300"
                               :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nouvelle image de couverture -->
                    <div class="form-group">
                        <label for="coverImage" class="block text-sm font-medium mb-2 transition-colors duration-300"
                               :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $book->coverImage ? 'Changer l\'image de couverture' : 'Ajouter une image de couverture' }}
                            </span>
                        </label>
                        <input type="file" name="coverImage" id="coverImage" accept="image/*"
                               class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                               :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }" />
                        <p class="mt-1 text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            Formats acceptés: JPEG, PNG, JPG, GIF. Taille max: 2MB
                        </p>
                        @error('coverImage')
                        <p class="mt-2 text-sm transition-colors duration-300"
                           :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Formations associées -->
                    <div class="form-group">
                        <label for="formations" class="block text-sm font-medium mb-2 transition-colors duration-300"
                               :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Formations associées
                            </span>
                        </label>
                        <div class="space-y-2 max-h-40 overflow-y-auto p-3 border rounded-lg transition-colors duration-300"
                             :class="{ 'bg-gray-700 border-gray-600': darkMode, 'bg-gray-50 border-gray-300': !darkMode }">
                            @php
                                $bookFormationIds = old('formations', $book->formations->pluck('id')->toArray());
                            @endphp
                            @foreach($formations as $formation)
                                <label class="flex items-center transition-colors duration-300"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    <input type="checkbox" name="formations[]" value="{{ $formation->id }}"
                                           {{ in_array($formation->id, $bookFormationIds) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-[#4CA3DD] shadow-sm focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50">
                                    <span class="ml-2 text-sm">{{ $formation->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-1 text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            Sélectionnez les formations pour lesquelles ce livre est recommandé
                        </p>
                        @error('formations')
                        <p class="mt-2 text-sm transition-colors duration-300"
                           :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Description
                    </span>
                </label>
                <textarea name="description" id="description" rows="4" placeholder="Description du livre, résumé, table des matières..."
                          class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                          :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }">{{ old('description', $book->description) }}</textarea>
                @error('description')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t transition-colors duration-300"
                 :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Mettre à jour
                </button>

                <a href="{{ route('admin.books.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex justify-center items-center px-6 py-3 border rounded-lg font-medium transition duration-150 ease-in-out"
                   :class="{
                       'bg-gray-700 border-gray-600 text-white hover:bg-gray-600': darkMode,
                       'bg-white border-gray-300 text-gray-700 hover:bg-gray-50': !darkMode
                   }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Information complémentaire -->
    <div class="p-4 rounded-lg mb-4 transition-colors duration-300"
         :class="{ 'bg-gray-700 text-gray-300': darkMode, 'bg-gray-100 text-gray-600': !darkMode }">
        <div class="flex flex-wrap items-center text-sm">
            <div class="flex items-center mr-6 mb-2 sm:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Ajouté le: {{ $book->created_at->format('d/m/Y à H:i') }}
            </div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dernière modification: {{ $book->updated_at->format('d/m/Y à H:i') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des alertes
            const alerts = document.querySelectorAll('[id^="alert-"]');
            alerts.forEach(alert => {
                const closeBtn = alert.querySelector('[data-dismiss-target]');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                        setTimeout(() => {
                            alert.remove();
                        }, 500);
                    });
                }

                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                        setTimeout(() => {
                            if (alert && alert.parentNode) {
                                alert.remove();
                            }
                        }, 500);
                    }
                }, 8000);
            });

            // Prévisualisation de la nouvelle image de couverture
            const coverImageInput = document.getElementById('coverImage');
            if (coverImageInput) {
                coverImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Créer un élément d'aperçu s'il n'existe pas
                            let preview = document.getElementById('cover-preview');
                            if (!preview) {
                                preview = document.createElement('img');
                                preview.id = 'cover-preview';
                                preview.className = 'mt-2 h-32 w-24 object-cover rounded border';
                                coverImageInput.parentNode.appendChild(preview);

                                // Ajouter un titre
                                const previewTitle = document.createElement('p');
                                previewTitle.className = 'mt-1 text-xs text-gray-500';
                                previewTitle.textContent = 'Aperçu de la nouvelle image:';
                                coverImageInput.parentNode.insertBefore(previewTitle, preview);
                            }
                            preview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endpush }" />
