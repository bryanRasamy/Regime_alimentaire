document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[data-ajax="true"]');
    if (!form) {
        return;
    }

    const feedback = document.querySelector('.form-feedback');
    const submitButton = form.querySelector('button[type="submit"]');
    const inputs = form.querySelectorAll('input');

    // Gestion de l'affichage du mot de passe
    const togglePasswordBtn = form.querySelector('.toggle-password');
    const passwordInput = form.querySelector('input[name="password"]');
    
    if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
            // Changement de l'icône (oeil/oeil barré)
            if (isPassword) {
                togglePasswordBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-off-icon"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
            } else {
                togglePasswordBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
            }
        });
    }

    const validateField = (input) => {
        let errorSpan = input.nextElementSibling;
        if (errorSpan && !errorSpan.classList.contains('field-error')) {
            errorSpan = input.parentElement.nextElementSibling;
        }
        
        let errorMessage = '';

        if (input.value.trim() === '') {
            errorMessage = 'Ce champ est obligatoire.';
        } else {
            if (input.name === 'name' && input.value.trim().length < 3) {
                errorMessage = 'Le nom doit contenir au moins 3 caractères.';
            }
            if (input.name === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value.trim())) {
                    errorMessage = 'Adresse email invalide.';
                }
            }
            if (input.name === 'password' && input.value.length < 6) {
                errorMessage = 'Le mot de passe doit contenir au moins 6 caractères.';
            }
        }

        if (errorMessage) {
            input.classList.add('input-error');
            if (errorSpan && errorSpan.classList.contains('field-error')) {
                errorSpan.textContent = errorMessage;
            }
            return false;
        } else {
            input.classList.remove('input-error');
            if (errorSpan && errorSpan.classList.contains('field-error')) {
                errorSpan.textContent = '';
            }
            return true;
        }
    };

    // Validation à la perte de focus (blur) et en direct si déjà en erreur
    inputs.forEach(input => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => {
            if (input.classList.contains('input-error')) {
                validateField(input);
            }
        });
    });

    const setFeedback = (message, isError) => {
        if (!feedback) {
            return;
        }

        feedback.textContent = message;
        feedback.style.color = isError ? '#b42318' : '#05603a';
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Validation intégrale avant envoi
        let isFormValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            setFeedback('Veuillez corriger les erreurs dans le formulaire.', true);
            return;
        }

        const originalBtnText = submitButton ? submitButton.innerHTML : '';
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg>';
        }

        // On efface l'erreur précédente
        setFeedback('', false);

        await new Promise(resolve => setTimeout(resolve, 800));

        try {
            const formData = new FormData(form);
            const plainFormData = Object.fromEntries(formData.entries());

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(plainFormData),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data.success) {
                const message = data.message || 'Inscription impossible.';
                setFeedback(message, true);
                return;
            }

            setFeedback(data.message || 'Inscription enregistree.', false);
            window.location.href = data.redirect || '/';
        } catch (error) {
            setFeedback('Erreur réseau. Réessayez.', true);
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = originalBtnText;
            }
        }
    });
});
