document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[data-ajax="true"]');
    if (!form) {
        return;
    }

    const feedback = document.querySelector('.form-feedback');
    const submitButton = form.querySelector('button[type="submit"]');
    const objectiveInputs = form.querySelectorAll('input[name="objectif"]');
    const valueWrapper = document.getElementById('objectif-value-wrapper');
    const valueLabel = document.getElementById('objectif-value-label');
    const valueInput = document.getElementById('objectif_value');
    const valueError = valueWrapper ? valueWrapper.querySelector('.field-error') : null;

    const setFeedback = (message, isError) => {
        if (!feedback) {
            return;
        }

        feedback.textContent = message;
        feedback.style.color = isError ? '#b42318' : '#05603a';
    };

    const getSelectedObjective = () => form.querySelector('input[name="objectif"]:checked');

    const updateObjectiveField = () => {
        const selected = getSelectedObjective();

        if (!selected || !valueWrapper || !valueInput || !valueLabel) {
            return;
        }

        valueWrapper.hidden = false;
        valueInput.value = '';
        valueInput.classList.remove('input-error');
        if (valueError) {
            valueError.textContent = '';
        }

        if (selected.value === 'augmenter_poids') {
            valueLabel.textContent = 'Combien de kilos souhaitez-vous gagner ?';
            valueInput.placeholder = 'Ex: 5';
            valueInput.step = '0.1';
            valueInput.min = '0.1';
        } else if (selected.value === 'reduire_poids') {
            valueLabel.textContent = 'Combien de kilos souhaitez-vous perdre ?';
            valueInput.placeholder = 'Ex: 8';
            valueInput.step = '0.1';
            valueInput.min = '0.1';
        } else if (selected.value === 'imc_ideale') {
            valueLabel.textContent = 'Quelle IMC cible souhaitez-vous atteindre ?';
            valueInput.placeholder = 'Ex: 22.5';
            valueInput.step = '0.1';
            valueInput.min = '1';
        }
    };

    const validateObjectiveValue = () => {
        if (!valueInput || !valueError || !valueWrapper || valueWrapper.hidden) {
            return true;
        }

        const value = parseFloat(valueInput.value);
        let errorMessage = '';

        if (valueInput.value.trim() === '' || Number.isNaN(value)) {
            errorMessage = 'Ce champ est obligatoire.';
        } else if (value <= 0) {
            errorMessage = 'Veuillez entrer une valeur positive.';
        }

        if (errorMessage) {
            valueInput.classList.add('input-error');
            valueError.textContent = errorMessage;
            return false;
        }

        valueInput.classList.remove('input-error');
        valueError.textContent = '';
        return true;
    };

    objectiveInputs.forEach(input => {
        input.addEventListener('change', updateObjectiveField);
    });

    if (valueInput) {
        valueInput.addEventListener('blur', validateObjectiveValue);
        valueInput.addEventListener('input', () => {
            if (valueInput.classList.contains('input-error')) {
                validateObjectiveValue();
            }
        });
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const selected = getSelectedObjective();
        const isValueValid = validateObjectiveValue();

        if (!selected || !isValueValid) {
            setFeedback('Veuillez selectionner un objectif et renseigner une valeur valide.', true);
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
                setFeedback(data.message || 'Enregistrement impossible.', true);
                return;
            }

            setFeedback(data.message || 'Objectif enregistre.', false);
            window.location.href = data.redirect || '/home';
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