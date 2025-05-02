document.addEventListener("DOMContentLoaded", () => {
    // Handle quantity buttons for associated products
    document.querySelectorAll('.decrease-qty').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.nextElementSibling;
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
                updateAssociatedProductPrice(input);
            }
        });
    });

    document.querySelectorAll('.increase-qty').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            let value = parseInt(input.value);
            input.value = value + 1;
            updateAssociatedProductPrice(input);
        });
    });

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (value < 1 || isNaN(value)) {
                this.value = 1;
            }
            updateAssociatedProductPrice(this);
        });
    });

    function updateAssociatedProductPrice(input) {
        const price = parseFloat(input.getAttribute('data-price'));
        const quantity = parseInt(input.value);
        const row = input.closest('tr');
        if (row) {
            const priceSpan = row.querySelector('td:last-child span');
            if (priceSpan) {
                priceSpan.textContent = '$' + (price * quantity).toFixed(2);
            }
        }
    }
});
