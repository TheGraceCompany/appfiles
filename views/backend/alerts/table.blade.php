<table class="table table-responsive" id="alerts-table">
    <thead>
        <th>Alert Title</th>
        <th>Alerttype</th>
        <th>Order Id</th>
        <th>User Id</th>
        <th>Product Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($alerts as $alert)
        <tr>
            <td>{!! $alert->alert_title !!}</td>
            <td>{!! $alert->alerttype !!}</td>
            <td>{!! $alert->order_id !!}</td>
            <td>{!! $alert->user_id !!}</td>
            <td>{!! $alert->product_id !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.alerts.destroy', $alert->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.alerts.show', [$alert->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.alerts.edit', [$alert->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>