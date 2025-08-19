@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                    <h4 class="mb-0 text-white font-weight-bold"><i class="fas fa-user-circle mr-2"></i>Profil de {{ $user->name }}</h4>
                </div>

                <div class="card-body p-4" style="background-color: #f8f9fa;">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" style="border-radius: 10px;">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label for="name" class="col-md-4 col-form-label text-md-right font-weight-bold" style="color: #495057;">Nom</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: #e9ecef; border-right: none;">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                    </div>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                           style="border-left: none; border-radius: 0 15px 15px 0;" 
                                           name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold" style="color: #495057;">Email</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: #e9ecef; border-right: none;">
                                            <i class="fas fa-envelope text-danger"></i>
                                        </span>
                                    </div>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                           style="border-left: none; border-radius: 0 15px 15px 0;" 
                                           name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Section Mot de Passe -->
                        <div class="form-group row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <div class="pt-3" style="border-top: 2px dashed #dee2e6;">
                                    <h5 class="font-weight-bold" style="color: #2575fc;">
                                        <i class="fas fa-lock mr-2"></i>Changer le mot de passe
                                    </h5>
                                    <small class="text-muted">Remplissez uniquement pour modifier</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right font-weight-bold" style="color: #495057;">Mot de passe actuel</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: #e9ecef; border-right: none;">
                                            <i class="fas fa-key text-warning"></i>
                                        </span>
                                    </div>
                                    <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           style="border-left: none; border-radius: 0 15px 15px 0;" 
                                           name="current_password" autocomplete="current-password">
                                </div>
                                @error('current_password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="password" class="col-md-4 col-form-label text-md-right font-weight-bold" style="color: #495057;">Nouveau mot de passe</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: #e9ecef; border-right: none;">
                                            <i class="fas fa-key text-success"></i>
                                        </span>
                                    </div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                           style="border-left: none; border-radius: 0 15px 15px 0;" 
                                           name="password" autocomplete="new-password">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text ml-4" style="color: #6c757d;">
                                    <i class="fas fa-info-circle mr-1" style="color: #17a2b8;"></i> 8 caractères min, avec majuscule, minuscule, chiffre et symbole
                                </small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right font-weight-bold" style="color: #495057;">Confirmation</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: #e9ecef; border-right: none;">
                                            <i class="fas fa-check-double text-info"></i>
                                        </span>
                                    </div>
                                    <input id="password-confirm" type="password" class="form-control" 
                                           style="border-left: none; border-radius: 0 15px 15px 0;" 
                                           name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-block py-2 font-weight-bold shadow" 
                                        style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); 
                                               border: none; border-radius: 15px; color: white;
                                               transition: all 0.3s ease;">
                                    <i class="fas fa-save mr-2"></i> Mettre à jour le profil
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f1f3f6;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .form-control:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 0.2rem rgba(37, 117, 252, 0.25);
    }
    .input-group-text {
        border-radius: 15px 0 0 15px !important;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }
</style>
@endsection

@section('scripts')
@if($errors->any())
<script>
    $(document).ready(function() {
        // Animation pour les erreurs
        $(".is-invalid").first().focus();
        $('html, body').animate({
            scrollTop: $(".is-invalid").first().offset().top - 100
        }, 500);
    });
</script>
@endif
@endsection