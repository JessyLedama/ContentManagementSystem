@component('mail::message')

You have a new order. Below are the full details:

**Customer**
- Name: {{ $order->customer->name }}
- Email: {{ $order->customer->email }}

**Address**
- County: {{ $order->address->county }}
- Town: {{ $order->address->town }}
- Street: {{ $order->address->street }}
- Phone: {{ $order->address->phone }}

**Products**
<table>
    <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>

    @foreach ($order->catalogue as $product)
        <tr>
            <td>
                {{ ucfirst($product->name) }} &nbsp; <br>
                <a href="{{ $product->url }}">View Product</a>
            </td>
            <td>
                {{ $product->pivot->quantity }}
            </td>
            <td>
                Ksh.{{ number_format($product->price) }}
            </td>
        </tr>
    @endforeach
</table>

<hr>

- Sales amount: **Ksh.{{ number_format($order->total - $order->shippingCost) }}**
- Delivery cost: **Ksh.{{ number_format($order->shippingCost) }}**

- Total amount: **Ksh.{{ number_format($order->total) }}**

@component('mail::button', ['url' => route('order.edit', $order)])
    View Order
@endcomponent

@endcomponent