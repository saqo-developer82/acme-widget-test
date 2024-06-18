class Shop {
    
    constructor() {
        const this_ = this;
        const selectedCountInputs = document.querySelectorAll('.selected-count-input');
        const addToBasketButtons = document.querySelectorAll('.add-to-basket-btn');
        const confirmOrderBtn = document.getElementById('confirm-order');

        this.backendPath = 'backend/Actions.php';

        if (selectedCountInputs.length) {
            selectedCountInputs.forEach(input => {
                input.addEventListener('change', (e) => {
                    e.target.parentElement.querySelector('button').disabled = !(e.target.value > 0);
                });
            });    
        }

        if (addToBasketButtons.length) {
            addToBasketButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    this_.addToBasket(e.target.getAttribute('data-product_id'), e.target.parentElement.querySelector('input').value);
                });
            });
        }

        if (confirmOrderBtn) {
            confirmOrderBtn.addEventListener('click', (e) => {
                this_.confirmOrder();
            });    
        }
    }
    
    addToBasket(product_id, count) {
        console.log(product_id);
        console.log(count);
        const data = {
            product_id,
            count,
            action: 'add_to_basket',
        };

        fetch(this.backendPath, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
    }

    confirmOrder() {
        const data = {
            action: 'confirm_order',
        };

        fetch(this.backendPath, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }).then(() => {
            document.getElementById('go-to-products').click();
        });
    }
}

window.Shop = new Shop();
