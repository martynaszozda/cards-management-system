<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the cards.
     */
    public function index()
    {
       $cards = Card::orderBy('created_at', 'desc')->paginate(10);
        return view('cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new card.
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created card in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_number' => 'required|digits:20|unique:cards,card_number',
            'pin' => 'required|digits:4',
            'activation_date' => 'required|date',
            'expiry_date' => 'required|date|after:today',
            'balance' => 'required|numeric|min:0',
        ]);

        Card::create($validated);

        return redirect()->route('cards.index')
            ->with('success', 'Card created successfully!');
    }

    /**
     * Display the specified card.
     */
    public function show(Card $card)
    {
        return view('cards.show', compact('card'));
    }

    /**
     * Show the form for editing the specified card.
     */
    public function edit(Card $card)
    {
        return view('cards.edit', compact('card'));
    }

    /**
     * Update the specified card in database.
     */
    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'card_number' => 'required|digits:20|unique:cards,card_number,' . $card->id,
            'pin' => 'required|digits:4',
            'activation_date' => 'required|date',
            'expiry_date' => 'required|date|after:today',
            'balance' => 'required|numeric|min:0',
        ]);

        $card->update($validated);

        return redirect()->route('cards.index')
            ->with('success', 'Card updated successfully!');
    }

    /**
     * Remove the specified card from database.
     */
    public function destroy(Card $card)
    {
        $card->delete();

        return redirect()->route('cards.index')
            ->with('success', 'Card deleted successfully!');
    }
}