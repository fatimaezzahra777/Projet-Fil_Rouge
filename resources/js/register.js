const registerForm = document.getElementById('registerForm');

if (registerForm) {
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
                circle.textContent = '✓';
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
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
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
                el.textContent = `${ok ? '✓' : '✗'} ${el.textContent.slice(2)}`;
                el.className = ok ? 'text-xs text-[#4CAF7D]' : 'text-xs text-[#7A9E93]';
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
            button.classList.toggle('border-[#235347]');
            button.classList.toggle('bg-[#235347]');
            button.classList.toggle('text-white');
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
