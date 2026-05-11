document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[data-ajax="true"]');
    if (!form) {
        return;
    }

    const feedback = document.querySelector('.form-feedback');
    const submitButton = form.querySelector('button[type="submit"]');
    const inputs = form.querySelectorAll('input');

    const validateField = (input) => {
        let errorSpan, errorMessage = '';
        let targetElement = input;

        if (input.type === 'radio') {
            const wrapper = input.closest('.radio-group-wrapper');
            errorSpan = wrapper.querySelector('.field-error');
            targetElement = wrapper.querySelector('.radio-group');
            
            const isChecked = form.querySelector(`input[name="${input.name}"]:checked`);
            if (!isChecked) {
                errorMessage = 'Veuillez selectionner un genre.';
            }
        } else {
            errorSpan = input.nextElementSibling;
            if (input.value.trim() === '') {
                errorMessage = 'Ce champ est obligatoire.';
            } else {
                if (input.name === 'taille') {
                    const val = parseFloat(input.value);
                    if (isNaN(val) || val < 0.5 || val > 2.5) {
                        errorMessage = 'Taille invalide (en metres, ex: 1.75).';
                    }
                }
                if (input.name === 'poids') {
                    const val = parseFloat(input.value);
                    if (isNaN(val) || val < 20 || val > 300) {
                        errorMessage = 'Poids invalide.';
                    }
                }
            }
        }

        if (errorMessage) {
            targetElement.classList.add('input-error');
            if (errorSpan && errorSpan.classList.contains('field-error')) {
                errorSpan.textContent = errorMessage;
            }
            return false;
        } else {
            targetElement.classList.remove('input-error');
            if (errorSpan && errorSpan.classList.contains('field-error')) {
                errorSpan.textContent = '';
            }
            return true;
        }
    };

    // Validation a la perte de focus (blur), clic, et en direct si deja en erreur
    inputs.forEach(input => {
        if (input.type === 'radio') {
            input.addEventListener('change', () => validateField(input));
        } else {
            input.addEventListener('blur', () => validateField(input));
            input.addEventListener('input', () => {
                if (input.classList.contains('input-error')) {
                    validateField(input);
                }
            });
        }
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

        // Validation integrale avant envoi
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
                const message = data.message || 'Enregistrement impossible.';
                setFeedback(message, true);
                return;
            }

            setFeedback(data.message || 'Informations enregistrees.', false);
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