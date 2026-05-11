document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[data-ajax="true"]');
    if (!form) {
        return;
    }

    const feedback = document.querySelector('.form-feedback');
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Gestion de l'affichage du mot de passe
    const togglePasswordBtn = form.querySelector('.toggle-password');
    const passwordInput = form.querySelector('input[name="password"]');
    
    if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
            // Changement de l'icône (oeil vs oeil barré)
            if (isPassword) {
                togglePasswordBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-off-icon"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
            } else {
                togglePasswordBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
            }
        });
    }

    const setFeedback = (message, isError) => {
        if (!feedback) {
            return;
        }

        feedback.textContent = message;
        feedback.style.color = isError ? '#b42318' : '#05603a';
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const email = form.querySelector('[name="email"]')?.value.trim() ?? '';
        const password = form.querySelector('[name="password"]')?.value ?? '';

        if (email === '' || password === '') {
            setFeedback('Email et mot de passe requis.', true);
            return;
        }

        const originalBtnText = submitButton ? submitButton.innerHTML : '';
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg>';
        }

        // On efface l'erreur précédente au lieu d'afficher "Connexion en cours..." en texte
        setFeedback('', false);

        // Petit délai artificiel pour que l'utilisateur voie la belle animation de chargement
        await new Promise(resolve => setTimeout(resolve, 800));

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
                body: formData,
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data.success) {
                const message = data.message || 'Email ou mot de passe incorrect.';
                setFeedback(message, true);
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalBtnText;
                }
                return;
            }

            setFeedback(data.message || 'Connexion reussie.', false);
            window.location.href = data.redirect || '/';
        } catch (error) {
            setFeedback('Erreur reseau. Reessayez.', true);
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = originalBtnText;
            }
        }
    });
});
