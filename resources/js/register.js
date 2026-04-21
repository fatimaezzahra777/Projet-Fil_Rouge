const registerForm = document.getElementById('registerForm');

if (registerForm) {
    const checkIcon = `
        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"></path>
        </svg>
    `;
    const crossIcon = `
        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M19 6.4 17.6 5 12 10.6 6.4 5 5 6.4l5.6 5.6L5 17.6 6.4 19l5.6-5.6 5.6 5.6 1.4-1.4-5.6-5.6z"></path>
        </svg>
    `;
    const eyeIcon = `
        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M12 5c-5 0-9.3 3.1-11 7 1.7 3.9 6 7 11 7s9.3-3.1 11-7c-1.7-3.9-6-7-11-7m0 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8m0-6.4A2.4 2.4 0 1 0 12 14a2.4 2.4 0 0 0 0-4.4"></path>
        </svg>
    `;
    const eyeOffIcon = `
        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M12 5c-5 0-9.3 3.1-11 7 1.7 3.9 6 7 11 7s9.3-3.1 11-7c-1.7-3.9-6-7-11-7m0 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8"></path>
            <path d="M4 3.6 20.4 20 19 21.4 2.6 5z"></path>
        </svg>
    `;
    const panels = Array.from(document.querySelectorAll('.panel'));
    const roleInput = document.getElementById('roleInput');
    const roleCards = Array.from(document.querySelectorAll('.role-card'));
    const passwordInput = document.getElementById('password');
    let selectedRole = roleInput?.value || 'patient';

    const updateProgress = (step) => {
        for (let i = 1; i <= 5; i += 1) {
            const circle = document.getElementById(`sc${i}`);
            const label = document.getElementById(`sl${i}`);

            if (!circle || !label) {
                continue;
            }

            if (i < step) {
                circle.className = 'flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#4CAF7D] text-[0.87rem] font-bold text-white transition-all';
                circle.innerHTML = checkIcon;
                label.className = 'hidden text-[0.78rem] font-semibold text-[#3A5A52] sm:inline';
            } else if (i === step) {
                circle.className = 'flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#235347] text-[0.87rem] font-bold text-white shadow-[0_0_0_4px_rgba(35,83,71,0.2)] transition-all';
                circle.textContent = String(i);
                label.className = 'hidden text-[0.78rem] font-semibold text-[#235347] sm:inline';
            } else {
                circle.className = 'flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EEF3F0] text-[0.87rem] font-bold text-[#7A9E93] transition-all';
                circle.textContent = String(i);
                label.className = 'hidden text-[0.78rem] font-semibold text-[#7A9E93] sm:inline';
            }
        }

        for (let i = 1; i <= 4; i += 1) {
            const line = document.getElementById(`line${i}`);

            if (line) {
                line.className = `mx-2 h-0.5 flex-1 ${i < step ? 'bg-[#4CAF7D]' : 'bg-[#EEF3F0]'}`;
            }
        }
    };

    const updateConfirmation = () => {
        const prenom = document.getElementById('prenom')?.value || '-';
        const nom = document.getElementById('nom')?.value || '';
        const email = document.getElementById('email')?.value || '-';
        const roleLabels = {
            patient: 'Patient',
            medecin: 'Medecin / Psychologue',
            association: 'Association',
        };

        const succName = document.getElementById('succName');
        const succRole = document.getElementById('succRole');
        const succEmail = document.getElementById('succEmail');

        if (succName) succName.textContent = `${prenom} ${nom}`.trim();
        if (succRole) succRole.textContent = roleLabels[selectedRole] || 'Patient';
        if (succEmail) succEmail.textContent = email;
    };

    const showStep = (step) => {
        panels.forEach((panel) => panel.classList.add('hidden'));

        const nextPanel = document.getElementById(`p${step}`);
        if (nextPanel) {
            nextPanel.classList.remove('hidden');
        }

        updateProgress(step);

        if (step === 5) {
            updateConfirmation();
        }
    };

    const updateRolePanels = () => {
        document.getElementById('patient-fields')?.classList.toggle('hidden', selectedRole !== 'patient');
        document.getElementById('medecin-fields')?.classList.toggle('hidden', selectedRole !== 'medecin');
        document.getElementById('assoc-fields')?.classList.toggle('hidden', selectedRole !== 'association');
    };

    const updateRoleCards = () => {
        roleCards.forEach((card) => {
            const isSelected = card.dataset.role === selectedRole;
            const check = card.querySelector('.role-check');

            card.classList.toggle('border-[#235347]', isSelected);
            card.classList.toggle('bg-[#DAF1DE]', isSelected);
            card.classList.toggle('border-[#D9E8E0]', !isSelected);
            card.classList.toggle('bg-white', !isSelected);

            if (check) {
                check.classList.toggle('hidden', !isSelected);
                check.classList.toggle('flex', isSelected);
            }
        });
    };

    const togglePassword = (inputId) => {
        const input = document.getElementById(inputId);
        const button = document.querySelector(`[data-toggle-password="${inputId}"]`);

        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        const icon = button?.querySelector('.password-toggle-icon');
        if (icon && input) {
            icon.innerHTML = input.type === 'password' ? eyeIcon : eyeOffIcon;
        }
    };

    const updatePasswordStrength = (value) => {
        const rules = {
            len: value.length >= 8,
            upper: /[A-Z]/.test(value),
            num: /[0-9]/.test(value),
            spec: /[^A-Za-z0-9]/.test(value),
        };

        const score = Object.values(rules).filter(Boolean).length;
        const color = score <= 1 ? 'bg-[#E05C5C]' : score <= 3 ? 'bg-[#E8A838]' : 'bg-[#4CAF7D]';
        const labels = ['Entrez un mot de passe', 'Tres faible', 'Faible', 'Moyen', 'Fort'];

        ['seg1', 'seg2', 'seg3', 'seg4'].forEach((id, index) => {
            const seg = document.getElementById(id);
            if (seg) {
                seg.className = `h-1 w-full rounded ${index < score ? color : 'bg-[#EEF3F0]'}`;
            }
        });

        const strengthLabel = document.getElementById('strengthLabel');
        if (strengthLabel) {
            strengthLabel.textContent = labels[score];
        }

        Object.entries(rules).forEach(([key, ok]) => {
            const el = document.getElementById(`r-${key}`);
            if (el) {
                const label = el.dataset.ruleLabel || '';
                el.innerHTML = `
                    <span class="rule-icon ${ok ? 'text-[#4CAF7D]' : 'text-[#7A9E93]'}">${ok ? checkIcon : crossIcon}</span>
                    <span>${label}</span>
                `;
                el.className = ok ? 'flex items-center gap-2 text-xs text-[#4CAF7D]' : 'flex items-center gap-2 text-xs text-[#7A9E93]';
            }
        });
    };

    roleCards.forEach((card) => {
        card.addEventListener('click', () => {
            selectedRole = card.dataset.role || 'patient';
            if (roleInput) {
                roleInput.value = selectedRole;
            }
            updateRoleCards();
            updateRolePanels();
        });
    });

    document.querySelectorAll('[data-next]').forEach((button) => {
        button.addEventListener('click', () => {
            showStep(Number(button.dataset.next));
        });
    });

    document.querySelectorAll('[data-prev]').forEach((button) => {
        button.addEventListener('click', () => {
            showStep(Number(button.dataset.prev));
        });
    });

    document.querySelectorAll('[data-toggle-password]').forEach((button) => {
        button.addEventListener('click', () => {
            togglePassword(button.dataset.togglePassword);
        });
    });

    document.querySelectorAll('.tag-btn').forEach((button) => {
        button.addEventListener('click', () => {
            const group = button.dataset.tagGroup;
            const hiddenInput = document.getElementById(button.dataset.tagTarget || '');
            const value = button.dataset.tagValue;

            if (!group || !hiddenInput || !value) {
                button.classList.toggle('border-[#235347]');
                button.classList.toggle('bg-[#235347]');
                button.classList.toggle('text-white');
                return;
            }

            if (group === 'patient') {
                const values = hiddenInput.value
                    .split(',')
                    .map((item) => item.trim())
                    .filter(Boolean);
                const index = values.indexOf(value);

                if (index >= 0) {
                    values.splice(index, 1);
                } else {
                    values.push(value);
                }

                hiddenInput.value = values.join(', ');
                button.classList.toggle('border-[#235347]', index < 0);
                button.classList.toggle('bg-[#235347]', index < 0);
                button.classList.toggle('text-white', index < 0);
                button.classList.toggle('border-[#D9E8E0]', index >= 0);
                button.classList.toggle('text-[#3A5A52]', index >= 0);
                return;
            }

            if (group === 'medecin') {
                document.querySelectorAll('[data-tag-group="medecin"]').forEach((tagButton) => {
                    tagButton.classList.remove('border-[#235347]', 'bg-[#235347]', 'text-white');
                    tagButton.classList.add('border-[#D9E8E0]', 'text-[#3A5A52]');
                });

                hiddenInput.value = value;
                button.classList.remove('border-[#D9E8E0]', 'text-[#3A5A52]');
                button.classList.add('border-[#235347]', 'bg-[#235347]', 'text-white');
            }
        });
    });

    passwordInput?.addEventListener('input', (event) => {
        updatePasswordStrength(event.target.value);
    });

    updateRoleCards();
    updateRolePanels();
    updateProgress(1);
    updatePasswordStrength(passwordInput?.value || '');

    if (registerForm.dataset.hasErrors === 'true') {
        showStep(2);
    }
}
