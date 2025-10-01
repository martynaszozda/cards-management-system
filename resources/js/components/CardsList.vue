<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Cards Management</h4>
                        <a href="/cards/create" class="btn btn-primary">
                            Add New Card
                        </a>
                    </div>

                    <div class="card-body">
                        <!-- Success message -->
                        <div v-if="successMessage" class="alert alert-success alert-dismissible fade show">
                            {{ successMessage }}
                            <button type="button" class="btn-close" @click="successMessage = null"></button>
                        </div>

                        <!-- Loading state -->
                        <div v-if="loading" class="text-center py-4">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <!-- Cards table -->
                        <div v-else-if="cards.data && cards.data.length > 0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Card Number</th>
                                            <th>PIN</th>
                                            <th>Activation Date</th>
                                            <th>Expiry Date</th>
                                            <th>Balance</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="card in cards.data" :key="card.id">
                                            <td>{{ formatCardNumber(card.card_number) }}</td>
                                            <td>****</td>
                                            <td>{{ formatDateTime(card.activation_date) }}</td>
                                            <td>{{ formatDate(card.expiry_date) }}</td>
                                            <td>${{ formatBalance(card.balance) }}</td>
                                            <td>
                                                <a :href="`/cards/${card.id}`" class="btn btn-sm btn-info">View</a>
                                                <a :href="`/cards/${card.id}/edit`" class="btn btn-sm btn-warning">Edit</a>
                                                <button @click="deleteCard(card.id)" class="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <nav v-if="cards.last_page > 1" class="mt-3">
                                <ul class="pagination">
                                    <li class="page-item" :class="{ disabled: cards.current_page === 1 }">
                                        <a class="page-link" href="#" @click.prevent="loadCards(cards.current_page - 1)">Previous</a>
                                    </li>
                                    <li v-for="page in cards.last_page" :key="page" class="page-item" :class="{ active: page === cards.current_page }">
                                        <a class="page-link" href="#" @click.prevent="loadCards(page)">{{ page }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: cards.current_page === cards.last_page }">
                                        <a class="page-link" href="#" @click.prevent="loadCards(cards.current_page + 1)">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <!-- Empty state -->
                        <div v-else class="alert alert-info">
                            No cards found. <a href="/cards/create">Create your first card!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CardsList',
    data() {
        return {
            cards: {
                data: [],
                current_page: 1,
                last_page: 1
            },
            loading: true,
            successMessage: null
        };
    },
    mounted() {
        this.loadCards();
        // Check for success message from URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success')) {
            this.successMessage = urlParams.get('success');
        }
    },
    methods: {
        async loadCards(page = 1) {
            this.loading = true;
            try {
                const response = await fetch(`/api/cards?page=${page}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                this.cards = await response.json();
            } catch (error) {
                console.error('Error loading cards:', error);
            } finally {
                this.loading = false;
            }
        },
        async deleteCard(id) {
            if (!confirm('Are you sure you want to delete this card?')) {
                return;
            }
            try {
                const response = await fetch(`/api/cards/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (response.ok) {
                    this.successMessage = 'Card deleted successfully!';
                    this.loadCards(this.cards.current_page);
                }
            } catch (error) {
                console.error('Error deleting card:', error);
                alert('Error deleting card');
            }
        },
        formatCardNumber(number) {
            return number.substring(0, 4) + ' **** **** ' + number.substring(16);
        },
        formatDateTime(dateTime) {
            return new Date(dateTime).toLocaleString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString('en-US');
        },
        formatBalance(balance) {
            return parseFloat(balance).toFixed(2);
        }
    }
};
</script>