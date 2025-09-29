@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Card Details</h4>
                    <a href="{{ route('cards.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th width="30%">Card Number:</th>
                                <td>{{ $card->card_number }}</td>
                            </tr>
                            <tr>
                                <th>PIN:</th>
                                <td>{{ $card->pin }}</td>
                            </tr>
                            <tr>
                                <th>Activation Date:</th>
                                <td>{{ $card->activation_date->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Expiry Date:</th>
                                <td>{{ $card->expiry_date->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <th>Balance:</th>
                                <td>${{ number_format($card->balance, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td>{{ $card->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At:</th>
                                <td>{{ $card->updated_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('cards.edit', $card) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('cards.destroy', $card) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection