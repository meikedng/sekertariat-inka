{!! Form::model($model, ['url' => $delete_url, 'method' => 'delete', 'class' => 'form-inline js-confirm', 'data-confirm' => $confirm_message] ) !!} 
{!! Form::button('<i class="glyphicon glyphicon-trash" aria-hidden="true"> Hapus</i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger')) !!}
{!! Form::close() !!}