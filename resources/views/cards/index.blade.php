@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Cards Management</h4>
                    <a href="{{ route('cards.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New Card
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($cards->count() > 0)
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
                                    @foreach($cards as $card)
                                    <tr>
                                        <td>{{ substr($card->card_number, 0, 4) . ' **** **** ' . substr($card->card_number, -4) }}</td>
                                        <td>****</td>
                                        <td>{{ $card->activation_date->format('Y-m-d H:i') }}</td>
                                        <td>{{ $card->expiry_date->format('Y-m-d') }}</td>
                                        <td>${{ number_format($card->balance, 2) }}</td>
                                        <td>
                                            <a href="{{ route('cards.show', $card) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('cards.edit', $card) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('cards.destroy', $card) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this card?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $cards->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No cards found. <a href="{{ route('cards.create') }}">Create your first card!</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection