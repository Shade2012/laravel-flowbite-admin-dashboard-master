
const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
const toggleNewPassword = document.getElementById('toggleNewPassword');
const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
const currentPasswordInput = document.getElementById('current-password');
const newPasswordInput = document.getElementById('passwordProfile');
const confirmPasswordInput = document.getElementById('confirm-password');
const iconCurrentPassword = document.getElementById('iconCurrentPassword');
const iconNewPassword = document.getElementById('iconNewPassword');
const iconConfirmPassword = document.getElementById('iconConfirmPassword');

toggleCurrentPassword.addEventListener('click', () => {
    // Toggle the type attribute
    const type = currentPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    currentPasswordInput.setAttribute('type', type);

    // Toggle the eye icon
    iconCurrentPassword.innerHTML = type === 'password' ? `
        <path stroke="currentColor" stroke-width="2" d="M3 12c0 1.2 4.03 6 9 6s9-4.8 9-6c0-1.2-4.03-6-9-6s-9 4.8-9 6Z"/>
        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
        <path stroke="currentColor" stroke-width="2" d="M1 1l22 22" />
    ` : `
        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
    `;
});

toggleNewPassword.addEventListener('click', () => {
    // Toggle the type attribute
    const type = newPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    newPasswordInput.setAttribute('type', type);

    // Toggle the eye icon
    iconNewPassword.innerHTML = type === 'password' ? `
        <path stroke="currentColor" stroke-width="2" d="M3 12c0 1.2 4.03 6 9 6s9-4.8 9-6c0-1.2-4.03-6-9-6s-9 4.8-9 6Z"/>
        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
        <path stroke="currentColor" stroke-width="2" d="M1 1l22 22" />
    ` : `
        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
    `;
});

toggleConfirmPassword.addEventListener('click', () => {
    // Toggle the type attribute
    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPasswordInput.setAttribute('type', type);

    // Toggle the eye icon
    iconConfirmPassword.innerHTML = type === 'password' ? `
        <path stroke="currentColor" stroke-width="2" d="M3 12c0 1.2 4.03 6 9 6s9-4.8 9-6c0-1.2-4.03-6-9-6s-9 4.8-9 6Z"/>
        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
        <path stroke="currentColor" stroke-width="2" d="M1 1l22 22" />
    ` : `
        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
    `;
});





