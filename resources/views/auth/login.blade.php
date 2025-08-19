<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - TasksManagerPro</title>
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
            --error: #ff3860;
            --gray: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--dark);
        }
        
        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }
        
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .left-panel::before {
            content: '';
            position: absolute;
            top: -70px;
            right: -70px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            z-index: 1;
        }
        
        .logo-icon {
            font-size: 32px;
            margin-right: 12px;
            background: white;
            color: var(--primary);
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 700;
        }
        
        .left-content {
            max-width: 400px;
            z-index: 1;
        }
        
        .left-title {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .left-text {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .features {
            list-style: none;
            margin-top: 30px;
        }
        
        .features li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .features i {
            background: rgba(255, 255, 255, 0.2);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 14px;
        }
        
        .right-panel {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .form-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }
        
        .form-subtitle {
            color: var(--gray);
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }
        
        .input-with-icon input {
            padding-left: 45px;
        }
        
        input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        .error-message {
            color: var(--error);
            font-size: 14px;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 5px;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }
        
        .remember {
            display: flex;
            align-items: center;
        }
        
        .remember input {
            width: auto;
            margin-right: 8px;
        }
        
        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .forgot-password:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 15px;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }
        
        .register-link {
            text-align: center;
            margin-top: 30px;
            color: var(--gray);
        }
        
        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .status-message {
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .status-success {
            background-color: rgba(75, 181, 67, 0.2);
            color: var(--success);
        }
        
        .status-error {
            background-color: rgba(255, 56, 96, 0.2);
            color: var(--error);
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                max-width: 100%;
            }
            
            .left-panel {
                display: none;
            }
            
            .right-panel {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="logo-text">TasksManagerPro</div>
            </div>
            <div class="left-content">
                <h2 class="left-title">Optimisez votre productivité</h2>
                <p class="left-text">TasksManagerPro vous aide à organiser vos projets, suivre votre progression et collaborer avec votre équipe.</p>
                
                <ul class="features">
                    <li><i class="fas fa-check"></i> Gestion de tâches intuitive</li>
                    <li><i class="fas fa-check"></i> Collaboration d'équipe en temps réel</li>
                    <li><i class="fas fa-check"></i> Rappels et échéances intelligents</li>
                    <li><i class="fas fa-check"></i> Rapports de progression détaillés</li>
                </ul>
            </div>
        </div>
        
        <div class="right-panel">
            <div class="form-header">
                <h1 class="form-title">Connexion</h1>
                <p class="form-subtitle">Accédez à votre espace de travail</p>
            </div>
            
            <!-- Session Status -->
            <div class="status-message status-success">
                <i class="fas fa-check-circle"></i>
                <span class="status-text">Session status message would appear here</span>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="votre@email.com">
                    </div>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Error messages for email would appear here</span>
                    </div>
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Votre mot de passe">
                    </div>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Error messages for password would appear here</span>
                    </div>
                </div>
                
                <!-- Remember Me -->
                <div class="remember-forgot">
                    <div class="remember">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">Se souvenir de moi</label>
                    </div>
                    
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Mot de passe oublié?
                    </a>
                </div>
                
                <button type="submit" class="btn-login">Se connecter</button>
                
                <div class="register-link">
                    <p>Vous n'avez pas de compte? <a href="{{ route('register') }}">Créer un compte</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Simple animation for input focus
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
</body>
</html>