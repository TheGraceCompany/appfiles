<table class="table table-striped table-bordered">
	<tr id="table-header">
		<td>#</td>
		<td>Items</td>
		<td>Status</td>
		<td>Total</td>
	</tr>
	@foreach($user->orders()->orderBy('created_at','desc')->get() as $order)
	<tr class="clickable" data-href="{{ url('/order/'.$order->id.'/show') }}">
		<td>{{ $order->id }}</td>
		<td>{{ $order->products->count() }}</td>
		<td>{{ $order->status }}</td>
		<td>${{ $order->amount }}</td>
	</tr>
	@endforeach
</table>
