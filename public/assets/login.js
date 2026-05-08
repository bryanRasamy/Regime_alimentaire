document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[data-ajax="true"]');
    if (!form) {
        return;
    }

    const feedback = document.querySelector('.form-feedback');
    const submitButton = form.querySelector('button[type="submit"]');

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

        if (submitButton) {
            submitButton.disabled = true;
        }

        setFeedback('Connexion en cours...', false);

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
                const message = data.message || 'Connexion impossible.';
                setFeedback(message, true);
                return;
            }

            setFeedback(data.message || 'Connexion reussie.', false);
            window.location.href = data.redirect || '/';
        } catch (error) {
            setFeedback('Erreur reseau. Reessayez.', true);
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
            }
        }
    });
});
