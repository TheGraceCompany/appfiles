<table class="table table-responsive" id="boxes-table">
    <thead>
        
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($boxes as $box)
        <tr>
            
            <td>
                {!! Form::open(['route' => ['admin.boxes.destroy', $box->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.boxes.show', [$box->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.boxes.edit', [$box->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>