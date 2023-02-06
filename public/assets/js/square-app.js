Alpine.data(
    'squarePaymentComponent',
    ({ state }) =>
    {
        let card;
        let payments;
        let cardButton;
        return {
            state,

            initializeCard: async function (payments) {
                const card = await payments.card();
                await card.attach('#card-container');

                return card;
            },

            createPayment: async function (token, price, subscriptionId) {
                return {
                    status: "success",
                    paymentId: "tucKXLI1F5RTrr7ptvRW1JsGoFCZY"
                };
            },

            tokenize: async function (paymentMethod) {
                const tokenResult = await paymentMethod.tokenize();
                if (tokenResult.status === 'OK') {
                    return tokenResult.token;
                } else {
                    let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
                    if (tokenResult.errors) {
                        errorMessage += ` and errors: ${JSON.stringify(
                            tokenResult.errors
                        )}`;
                    }

                    throw new Error(errorMessage);
                }
            },

            displayPaymentResults: function (status) {
                const statusContainer = document.getElementById(
                    'payment-status-container'
                );

                // status is either SUCCESS or FAILURE;
                if (status === 'SUCCESS') {
                    statusContainer.classList.remove('is-failure');
                    statusContainer.classList.add('is-success');
                } else {
                    statusContainer.classList.remove('is-success');
                    statusContainer.classList.add('is-failure');
                }

                statusContainer.style.visibility = 'visible';
            },

            launchSquareForm: async function (squareAppId, squareLocationId) {
                if (!window.Square) {
                    throw new Error('Square.js failed to load properly');
                }

                try {
                    payments = window.Square.payments(squareAppId, squareLocationId);
                } catch {
                    const statusContainer = document.getElementById(
                        'payment-status-container'
                    );
                    statusContainer.className = 'missing-credentials';
                    statusContainer.style.visibility = 'visible';
                    return;
                }

                try {
                    card = await this.initializeCard(payments);
                } catch (e) {
                    console.error('Initializing Card failed', e);
                    return;
                }

                cardButton = document.getElementById('card-button');
            },

            handleCardButtonClicked: async function (price, subscriptionId) {
                try {
                    // disable the submit button as we await tokenization and make a payment request.
                    cardButton.disabled = true;
                    const token = await this.tokenize(card);
                    const paymentResults = await this.createPayment(token, price, subscriptionId);
                    this.displayPaymentResults('SUCCESS');

                    this.state = paymentResults['paymentId'];
//                    dispatchEvent(new Event('change'));
                    console.debug('Payment Success', paymentResults);
                } catch (e) {
                    cardButton.disabled = false;
                    this.displayPaymentResults('FAILURE');
                    console.error(e.message);
                }
            }
        }
    }
);
