@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Card</div>

                <div class="card-body">
                    <form action="{{ route('cards.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="card_number" class="form-label">Card Number (20 digits) *</label>
                            <input type="text" 
                                   class="form-control @error('card_number') is-invalid @enderror" 
                                   id="card_number" 
                                   name="card_number" 
                                   value="{{ old('card_number') }}"
                                   placeholder="12345678901234567890"
                                   maxlength="20"
                                   required>
                            @error('card_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pin" class="form-label">PIN (4 digits) *</label>
                            <input type="text" 
                                   class="form-control @error('pin') is-invalid @enderror" 
                                   id="pin" 
                                   name="pin" 
                                   value="{{ old('pin') }}"
                                   placeholder="1234"
                                   maxlength="4"
                                   required>
                            @error('pin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="activation_date" class="form-label">Activation Date *</label>
                            <input type="datetime-local" 
                                   class="form-control @error('activation_date') is-invalid @enderror" 
                                   id="activation_date" 
                                   name="activation_date" 
                                   value="{{ old('activation_date') }}"
                                   required>
                            @error('activation_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date *</label>
                            <input type="date" 
                                   class="form-control @error('expiry_date') is-invalid @enderror" 
                                   id="expiry_date" 
                                   name="expiry_date" 
                                   value="{{ old('expiry_date') }}"
                                   required>
                            @error('expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="balance" class="form-label">Balance *</label>
                            <input type="number" 
                                   class="form-control @error('balance') is-invalid @enderror" 
                                   id="balance" 
                                   name="balance" 
                                   value="{{ old('balance', '0.00') }}"
                                   step="0.01"
                                   min="0"
                                   required>
                            @error('balance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Create Card</button>
                            <a href="{{ route('cards.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection