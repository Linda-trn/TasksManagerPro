<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - TasksManagerPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4bb543;
            --error: #ff6b6b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .logo-icon {
            background: var(--primary);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }
        
        .logo-text {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .tagline {
            color: var(--dark);
            font-size: 18px;
            font-weight: 300;
        }
        
        .card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .card-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .card-left h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        
        .card-left p {
            margin-bottom: 25px;
            font-weight: 300;
            line-height: 1.6;
        }
        
        .features {
            list-style: none;
            margin-top: 30px;
        }
        
        .features li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-weight: 300;
        }
        
        .features i {
            margin-right: 10px;
            background: rgba(255, 255, 255, 0.2);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card-right {
            flex: 1;
            padding: 40px;
        }
        
        .form-title {
            color: var(--primary);
            font-size: 24px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 500;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
        }
        
        .input-icon input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e1e5ee;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .input-icon input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        .btn {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            color: var(--dark);
        }
        
        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .password-requirements {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 14px;
        }
        
        .password-requirements p {
            margin-bottom: 10px;
            color: var(--dark);
            font-weight: 500;
        }
        
        .password-requirements ul {
            list-style: none;
            padding-left: 5px;
        }
        
        .password-requirements li {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            color: #6c757d;
        }
        
        .password-requirements li i {
            margin-right: 8px;
            font-size: 12px;
        }
        
        .requirement-met {
            color: var(--success) !important;
        }
        
        @media (max-width: 900px) {
            .card {
                flex-direction: column;
            }
            
            .card-left {
                padding: 30px;
            }
        }
    </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="logo-text">TasksManagerPro</div>
            </div>
            <p class="tagline">La solution professionnelle pour gérer vos projets efficacement</p>
        </div>
        
        <div class="card">
            <div class="card-left">
                <h2>Rejoignez TasksManagerPro</h2>
                <p>Inscrivez-vous dès aujourd'hui et transformez votre façon de gérer les tâches et projets.</p>
                
                <ul class="features">
                    <li><i class="fas fa-check"></i> Gestion intuitive des tâches</li>
                    <li><i class="fas fa-check"></i> Collaboration en temps réel</li>
                    <li><i class="fas fa-check"></i> Rapports et analyses avancés</li>
                    <li><i class="fas fa-check"></i> Synchronisation multi-appareils</li>
                </ul>
            </div>
            
            <div class="card-right">
                <h2 class="form-title">Créer un compte</h2>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="input-group">
                        <label for="name">Nom complet</label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Votre nom complet">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="email">Adresse email</label>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="votre@email.com">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="password">Mot de passe</label>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Votre mot de passe">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmez votre mot de passe">
                        </div>
                    </div>
                    
                    <div class="password-requirements">
                        <p>Votre mot de passe doit contenir :</p>
                        <ul>
                            <li><i class="fas fa-circle"></i> Au moins 8 caractères</li>
                            <li><i class="fas fa-circle"></i> Une lettre majuscule</li>
                            <li><i class="fas fa-circle"></i> Un chiffre</li>
                            <li><i class="fas fa-circle"></i> Un caractère spécial</li>
                        </ul>
                    </div>
                    
                    <button type="submit" class="btn">Créer mon compte</button>
                    
                    <div class="login-link">
                        Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous ici</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Script pour la validation visuelle des mots de passe
        const passwordInput = document.getElementById('password');
        const requirements = document.querySelectorAll('.password-requirements li');
        
        passwordInput.addEventListener('input', function() {
            const value = this.value;
            
            // Au moins 8 caractères
            if (value.length >= 8) {
                requirements[0].classList.add('requirement-met');
                requirements[0].innerHTML = '<i class="fas fa-check"></i> Au moins 8 caractères';
            } else {
                requirements[0].classList.remove('requirement-met');
                requirements[0].innerHTML = '<i class="fas fa-circle"></i> Au moins 8 caractères';
            }
            
            // Une lettre majuscule
            if (/[A-Z]/.test(value)) {
                requirements[1].classList.add('requirement-met');
                requirements[1].innerHTML = '<i class="fas fa-check"></i> Une lettre majuscule';
            } else {
                requirements[1].classList.remove('requirement-met');
                requirements[1].innerHTML = '<i class="fas fa-circle"></i> Une lettre majuscule';
            }
            
            // Un chiffre
            if (/[0-9]/.test(value)) {
                requirements[2].classList.add('requirement-met');
                requirements[2].innerHTML = '<i class="fas fa-check"></i> Un chiffre';
            } else {
                requirements[2].classList.remove('requirement-met');
                requirements[2].innerHTML = '<i class="fas fa-circle"></i> Un chiffre';
            }
            
            // Un caractère spécial
            if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value)) {
                requirements[3].classList.add('requirement-met');
                requirements[3].innerHTML = '<i class="fas fa-check"></i> Un caractère spécial';
            } else {
                requirements[3].classList.remove('requirement-met');
                requirements[3].innerHTML = '<i class="fas fa-circle"></i> Un caractère spécial';
            }
        });
    </script>
</body>
</html>