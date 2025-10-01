<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ isEdit ? 'Edit' : 'Create New' }} Card</div>

                    <div class="card-body">
                        <form @submit.prevent="submitForm">
                            <!-- Card Number -->
                            <div class="mb-3">
                                <label for="card_number" class="form-label">Card Number (20 digits) *</label>
                                <input 
                                    type="text" 
                                    class="form-control"
                                    :class="{ 'is-invalid': errors.card_number }"
                                    id="card_number" 
                                    v-model="form.card_number"
                                    placeholder="12345678901234567890"
                                    maxlength="20"
                                    required
                                >
                                <div v-if="errors.card_number" class="invalid-feedback">
                                    {{ errors.card_number[0] }}
                                </div>
                            </div>

                            <!-- PIN -->
                            <div class="mb-3">
                                <label for="pin" class="form-label">PIN (4 digits) *</label>
                                <input 
                                    type="text" 
                                    class="form-control"
                                    :class="{ 'is-invalid': errors.pin }"
                                    id="pin" 
                                    v-model="form.pin"
                                    placeholder="1234"
                                    maxlength="4"
                                    required
                                >
                                <div v-if="errors.pin" class="invalid-feedback">
                                    {{ errors.pin[0] }}
                                </div>
                            </div>

                            <!-- Activation Date -->
                            <div class="mb-3">
                                <label for="activation_date" class="form-label">Activation Date *</label>
                                <input 
                                    type="datetime-local" 
                                    class="form-control"
                                    :class="{ 'is-invalid': errors.activation_date }"
                                    id="activation_date" 
                                    v-model="form.activation_date"
                                    required
                                >
                                <div v-if="errors.activation_date" class="invalid-feedback">
                                    {{ errors.activation_date[0] }}
                                </div>
                            </div>

                            <!-- Expiry Date -->
                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date *</label>
                                <input 
                                    type="date" 
                                    class="form-control"
                                    :class="{ 'is-invalid': errors.expiry_date }"
                                    id="expiry_date" 
                                    v-model="form.expiry_date"
                                    required
                                >
                                <div v-if="errors.expiry_date" class="invalid-feedback">
                                    {{ errors.expiry_date[0] }}
                                </div>
                            </div>

                            <!-- Balance -->
                            <div class="mb-3">
                                <label for="balance" class="form-label">Balance *</label>
                                <input 
                                    type="number" 
                                    class="form-control"
                                    :class="{ 'is-invalid': errors.balance }"
                                    id="balance" 
                                    v-model="form.balance"
                                    step="0.01"
                                    min="0"
                                    required
                                >
                                <div v-if="errors.balance" class="invalid-feedback">
                                    {{ errors.balance[0] }}
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success" :disabled="submitting">
                                    <span v-if="submitting" class="spinner-border spinner-border-sm me-1"></span>
                                    {{ isEdit ? 'Update' : 'Create' }} Card
                                </button>
                                <a href="/cards" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CardForm',
    props: {
        cardId: {
            type: [String, Number],
            default: null
        },
        initialData: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            form: {
                card_number: '',
                pin: '',
                activation_date: '',
                expiry_date: '',
                balance: '0.00'
            },
            errors: {},
            submitting: false
        };
    },
    computed: {
        isEdit() {
            return !!this.cardId;
        }
    },
    mounted() {
        if (this.isEdit && this.cardId) {
            this.loadCard();
        }
        // Load initial data if provided
        if (Object.keys(this.initialData).length > 0) {
            this.form = { ...this.initialData };
        }
    },
    methods: {
        async loadCard() {
            try {
                const response = await fetch(`/api/cards/${this.cardId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const card = await response.json();
                this.form = {
                    card_number: card.card_number,
                    pin: card.pin,
                    activation_date: card.activation_date.substring(0, 16), // Format for datetime-local
                    expiry_date: card.expiry_date,
                    balance: card.balance
                };
            } catch (error) {
                console.error('Error loading card:', error);
            }
        },
        async submitForm() {
            this.submitting = true;
            this.errors = {};

            const url = this.isEdit ? `/api/cards/${this.cardId}` : '/api/cards';
            const method = this.isEdit ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(this.form)
                });

                const data = await response.json();

                if (response.ok) {
                    window.location.href = '/cards?success=' + encodeURIComponent(
                        this.isEdit ? 'Card updated successfully!' : 'Card created successfully!'
                    );
                } else if (response.status === 422) {
                    this.errors = data.errors;
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('Error submitting form');
            } finally {
                this.submitting = false;
            }
        }
    }
};
</script>