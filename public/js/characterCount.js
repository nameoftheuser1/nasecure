document.addEventListener('DOMContentLoaded', (event) => {
    function updateCharacterCount(input, countElement) {
        countElement.textContent = `${input.value.length}`;
    }

    function attachCharacterCount(inputId, countId) {
        const inputElement = document.getElementById(inputId);
        const countElement = document.getElementById(countId);

        if (inputElement && countElement) {
            inputElement.addEventListener('input', () => {
                updateCharacterCount(inputElement, countElement);
            });

            updateCharacterCount(inputElement, countElement);
        }
    }

    attachCharacterCount('pin_code', 'pin_code_count');
    attachCharacterCount('rfid', 'rfid_count');
});
