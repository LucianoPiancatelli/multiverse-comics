<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $comicIds = array_keys($cart);

        $items = $comicIds
            ? Comic::whereIn('id', $comicIds)->get()->map(function (Comic $comic) use ($cart) {
                $quantity = $cart[$comic->id]['quantity'] ?? 0;
                $subtotal = $quantity * (float) $comic->price;

                return [
                    'comic' => $comic,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            })
            : collect();

        $total = $items->sum('subtotal');

        return view('cart.index', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'comic_id' => ['required', 'exists:comics,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $comic = Comic::findOrFail($request->integer('comic_id'));
        $quantity = max(1, (int) $request->input('quantity', 1));

        $cart = session()->get('cart', []);
        $currentQty = $cart[$comic->id]['quantity'] ?? 0;
        $cart[$comic->id] = [
            'quantity' => min($comic->stock, $currentQty + $quantity),
        ];

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('status', "{$comic->title} se agrego al carrito.");
    }

    public function update(Request $request, Comic $comic)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        if (! isset($cart[$comic->id])) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'El comic no esta en el carrito.');
        }

        $quantity = min($comic->stock, (int) $request->integer('quantity'));
        $cart[$comic->id]['quantity'] = $quantity;
        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('status', "Actualizaste la cantidad de {$comic->title}.");
    }

    public function destroy(Comic $comic)
    {
        $cart = session()->get('cart', []);
        unset($cart[$comic->id]);
        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('status', "{$comic->title} se elimino del carrito.");
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('status', 'Vaciaste el carrito.');
    }
}
